<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class WeOnTheMediaSaveRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'date' => 'required|date',
            'youtube_link' => 'nullable|url',
            'status' => 'nullable|boolean',
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["title.$locale"] = 'required|string|max:255';
            $rules["subtitle.$locale"] = 'nullable|string|max:255';
        }

        return $rules;
    }

    public function attributes()
    {
        $attributes = [
            'image' => 'Şəkil',
            'date' => 'Tarix',
            'youtube_link' => 'YouTube Link',
        ];

        foreach (config('translatable.locales') as $locale) {
            $attributes["title.$locale"] = "Başlıq ($locale)";
            $attributes["subtitle.$locale"] = "Alt başlıq ($locale)";
        }

        return $attributes;
    }
}