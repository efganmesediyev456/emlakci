<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class CountrySaveRequest extends FormRequest
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
            'title.required' => 'Ölkə adı sahəsi məcburidir',
            'title.*.required' => 'Ölkə adı sahəsi məcburidir',
            'title.*.string' => 'Ölkə adı sahəsi mətn olmalıdır',
            'title.*.max' => 'Ölkə adı sahəsi maksimum 255 simvol ola bilər',
        ];
    }
}