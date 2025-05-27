<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\About\AboutResource;
use App\Http\Resources\AdvertisementResource;
use App\Http\Resources\BlogAndNewsResource;
use App\Http\Resources\ExamResource;
use App\Http\Resources\LanguageResource;
use App\Http\Resources\Products\ProductResource;
use App\Http\Resources\Users\UserResource;
use App\Models\About;
use App\Models\Advertisement;
use App\Models\BlogNew;
use App\Models\ExamQuestion;
use App\Models\HaveQuestion;
use App\Models\Language;
use App\Models\Product;
use App\Models\User;
use App\Models\UserExam;
use App\Models\UserExamStart;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Http\Resources\ExamInnerResource;
use App\Http\Resources\ExamInnerResultResource;
use Auth;
use DB;

class ExamsController extends Controller
{

    public $user;

    public function __construct()
    {
        parent::__construct();
        $this->user = Auth::guard('api')->user();
    }
    public function getExam(Request $request, $subcategory, $exam)
    {

        $item = Exam::with('questions')->get()->filter(function ($q) use ($exam) {
            return $q->slug == $exam;
        })->first();

        return response()->json([
            'exam' => new ExamResource($item),
            'questions' => ExamInnerResource::collection($item->questions),
        ]);
    }



    public function postExam(Request $request, $subcategory, $exam)
    {
        $this->validate($request, [
            "questions" => "required|array",
            "questions.*.question_id" => "required",
            "questions.*.answer_id" => "required",
        ]);

        $item = Exam::with('questions')->get()->filter(function ($q) use ($exam) {
            return $q->slug == $exam;
        })->first();
        $examStart = UserExamStart::where("user_id", $this->user->id)->where("exam_id", $item->id)->first();
        $examStart->update([
            "end_at" => now()
        ]);
        UserExam::where('user_id', $this->user->id)->where('exam_id', $item->id)->delete();
        $userexam = null;
        foreach ($request->questions as $answer) {
            $userexam = UserExam::create([
                "user_id" => $this->user->id,
                "exam_id" => $item->id,
                "exam_question_id" => array_key_exists("question_id", $answer) ? $answer['question_id'] : null,
                "answer" => array_key_exists("answer", $answer) ? $answer['answer'] : null,
                "answer_id" => array_key_exists("answer_id", $answer) ? $answer['answer_id'] : null
            ]);
        }

        $correctOptionsCount = UserExam::where('user_id', $this->user->id)
            ->where('exam_id', $item->id)->whereHas("examQuestionOption", function ($qq) {
                return $qq->where("is_correct", 1);
            })->count();

        $unCorrectOptionsCount = UserExam::where('user_id', $this->user->id)
            ->where('exam_id', $item->id)->whereHas("examQuestionOption", function ($qq) {
                return $qq->where("is_correct", 0);
            })->count();

        $userAnswers = UserExam::where('user_id', $this->user->id)
            ->where('exam_id', $item->id)->get()->pluck("exam_question_id")->toArray();

        $notAnswersCount = $item->questions()->whereNotIn("id", $userAnswers)->where('type', 1)->count();

        return response()->json([
            "user" => [
                "name" => auth('api')->user()->name,
                "surname" => auth('api')->user()->surname,
                "topic" => $item->title,
                "date" => $examStart->created_at->translatedFormat('d F Y')
            ],
            "answers" => [
                "user_answers" => $item->questions->map(fn($question) => [
                    "id" => $question->id,
                    "variant" => $this->orderQuestionAnswer(
                        UserExam::where('user_id', $this->user->id)
                            ->where('exam_id', $item->id)
                            ->where('exam_question_id', $question->id)
                            ->first()?->examQuestionOption
                    ),
                    "type" => $question->type,
                    "typeName" => match ($question->type) {
                        2 => "Açıq sual",
                        1 => "Qapalı",
                        default => "Naməlum"
                    }
                ]),

                "system" => $item->questions->map(fn($question) => [
                    "id" => $question->id,
                    "variant" => $this->orderQuestionAnswer(
                        $question->options()->where('is_correct', 1)->first()
                    ),
                    "type" => $question->type,
                    "typeName" => match ($question->type) {
                        2 => "Açıq sual",
                        1 => "Qapalı",
                        default => "Naməlum"
                    }
                ]),

                "correct_answers" => $item->questions->map(function ($question) use ($item) {
                    $answer = UserExam::where('user_id', $this->user->id)
                        ->where('exam_id', $item->id)
                        ->where('exam_question_id', $question->id)
                        ->first()?->examQuestionOption;

                    if (is_null($answer)) {
                        return [
                            "id" => $question->id,
                            "value" => null
                        ];
                    }

                    return [
                        "id" => $question->id,
                        "value" => $question->type == 1 ? (($answer?->is_correct == 1) ? "+" : "-") : null
                    ];
                }),
            ],
            "results" => [
                "correctOptionsCount" => $correctOptionsCount,
                "unCorrectOptionsCount" => $unCorrectOptionsCount,
                "notAnswersCount" => $notAnswersCount
            ]
        ]);
    }


    public function startExam($subcategory, $exam)
    {
        try {
            DB::beginTransaction();
            $exam = Exam::with('questions')->get()->filter(function ($q) use ($exam) {
                return $q->slug == $exam;
            })->first();
            UserExamStart::where("user_id", $this->user->id)->where("exam_id", $exam->id)->delete();
            $data=UserExamStart::create([
                "user_id" => $this->user->id,
                "exam_id" => $exam->id,
                "start_at" => now(),
                "end_at" => null,
            ]);
            $data = [
                "user_id" => $data->user_id,
                "start_at"=>$data->start_at->format('Y-m-d H:i:s'),
                "end_at"=>$data->end_at,
            ];
            
            DB::commit();
            return $this->responseMessage('success', 'Uğurla imtahana başladınız', $data, 200, null);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseMessage('error', $exception->getMessage(), [], 500);
        }
    }



    public function orderQuestionAnswer($order)
    {
        $options = $order?->question?->options;

        $sortedOptions = $options?->sortBy('order');

        $result = [];
        if ($sortedOptions and count($sortedOptions)) {
            foreach ($sortedOptions as $index => $option) {

                if ($option->id == $order->id) {
                    $alphabeticValue = chr(65 + $index);
                    return $alphabeticValue;
                }
            }
        }

        return null;
    }



    public function getResults($subcategory, $exam)
    {
        $exam = Exam::with('questions')->get()->filter(function ($q) use ($exam) {
            return $q->slug == $exam;
        })->first();

        return response()->json([
            'exam' => new ExamResource($exam),
            'questions' => ExamInnerResultResource::collection($exam->questions)
        ]);
    }
}
