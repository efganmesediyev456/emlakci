<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FaqSaveRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|array',
            'title.*' => 'required|string|max:255',
            'description' => 'required|array',
            'description.*' => 'required|string',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'title' => 'Başlıq',
            'title.*' => 'Başlıq',
            'description' => 'Təsvir',
            'description.*' => 'Təsvir',
            'icon' => 'İkon',
        ];
    }
}