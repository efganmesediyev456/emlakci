<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class AdvantageSaveRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ];
    }
}