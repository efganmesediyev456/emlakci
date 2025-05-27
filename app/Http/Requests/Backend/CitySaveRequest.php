<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class CitySaveRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'country_id' => 'required|exists:countries,id',
            'title' => 'required|array',
            'title.*' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'country_id.required' => 'Ölkə sahəsi məcburidir',
            'country_id.exists' => 'Seçilən ölkə mövcud deyil',
            'title.required' => 'Şəhər adı sahəsi məcburidir',
            'title.*.required' => 'Şəhər adı sahəsi məcburidir',
            'title.*.string' => 'Şəhər adı sahəsi mətn olmalıdır',
            'title.*.max' => 'Şəhər adı sahəsi maksimum 255 simvol ola bilər',
        ];
    }
}