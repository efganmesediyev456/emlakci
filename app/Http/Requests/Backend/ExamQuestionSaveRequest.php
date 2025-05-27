<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class ExamQuestionSaveRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'question_text' => 'required|array',
            'question_text.*' => 'required|string',
            // 'points' => 'required|integer|min:1',
            // 'position' => 'required|integer|min:0',
            // 'type' => 'required|integer',
            'options' => 'required_if:type,1|array|min:2',
            'options.*.texts' => 'required|array',
            'options.*.texts.*' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'question_text.required' => 'Sual mətni tələb olunur',
            'question_text.*.required' => 'Sual mətni bütün dillərdə tələb olunur',
            'points.required' => 'Xal tələb olunur',
            'points.integer' => 'Xal rəqəm olmalıdır',
            'points.min' => 'Xal ən azı 1 olmalıdır',
            'position.required' => 'Sıra tələb olunur',
            'position.integer' => 'Sıra rəqəm olmalıdır',
            'position.min' => 'Sıra ən azı 0 olmalıdır',
            'type.required' => 'Tip tələb olunur',
            'options.required' => 'Cavab variantları tələb olunur',
            'options.min' => 'Ən azı 2 cavab variantı olmalıdır',
            'options.*.texts.required' => 'Variant mətni tələb olunur',
            'options.*.texts.*.required' => 'Variant mətni bütün dillərdə tələb olunur',
        ];
    }
}