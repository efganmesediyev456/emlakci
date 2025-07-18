<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class CategorySaveRequest extends FormRequest
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
            'subtitle' => 'nullable|array',
            'subtitle.*' => 'nullable|string|max:255',
            'description' => 'nullable|array',
            'description.*' => 'nullable|string',
            'slug' => 'nullable|array',
            'slug.*' => 'nullable|string|max:255',
            'seo_keywords' => 'nullable|array',
            'seo_keywords.*' => 'nullable|string',
            'seo_description' => 'nullable|array',
            'seo_description.*' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ];
    }
}