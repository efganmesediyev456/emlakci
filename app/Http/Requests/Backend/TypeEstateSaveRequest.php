<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class TypeEstateSaveRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|array',
            'title.*' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Başlıq sahəsi məcburidir',
            'title.*.required' => 'Başlıq sahəsi məcburidir',
            'title.*.string' => 'Başlıq sahəsi mətn olmalıdır',
            'title.*.max' => 'Başlıq sahəsi maksimum 255 simvol ola bilər',
        ];
    }
}