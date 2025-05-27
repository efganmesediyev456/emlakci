<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class TopicCategorySaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|array',
            'title.*' => 'required|string|max:255',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'Kateqoriya başlığı tələb olunur',
            'title.array' => 'Kateqoriya başlığı düzgün formatda deyil',
            'title.*.required' => 'Bütün dillər üçün kateqoriya başlığı daxil edilməlidir',
            'title.*.string' => 'Kateqoriya başlığı mətn formatında olmalıdır',
            'title.*.max' => 'Kateqoriya başlığı maksimum 255 simvol ola bilər',
        ];
    }
}