<?php

namespace App\Http\Resources;

use App\Models\Language;
use Illuminate\Http\Resources\Json\JsonResource;

class UserExamStartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */


    private function getTranslatedSlugs($item): array
    {
        $languages = Language::pluck('code')->toArray();

        $slugs = [];
        foreach ($languages as $lang) {
            $slugs[$lang] = $item->translate($lang)->slug ?? null;
        }

        return $slugs;
    }



    public function toArray($request)
    {
        $correct = $this->userExams->filter(function ($it) {
            return $it->examQuestionOption->is_correct;
        });
        $unCorrect = $this->userExams->filter(function ($it) {
            return $it->examQuestionOption->is_correct == 0;
        });

        $questionsArrayId = $this->userExams[0]->exam->questions->pluck('id')->toArray();

        $userAnswersId = $this->userExams->pluck('exam_question_id')->toArray();
        $unAnswers = array_diff($questionsArrayId, $userAnswersId);


        return [
            'id' => $this->id,
            'topic' => $this->exam?->title,
            'questionCount' => $this->userExams[0]->exam->questions->count(),
            'questionCorrect' => count($correct),
            'unQuestionCorrect' => count($unCorrect),
            'unAnswers' => count($unAnswers),
            'examSlug' => $this->getTranslatedSlugs($this->userExams[0]->exam),
            'active'=>auth('api')->user()->hasActiveSubscription($this->userExams[0]->exam->subCategory)
        ];
    }
}