<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class EstateSaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'price' => 'nullable|numeric|min:0',
            'area' => 'nullable|numeric|min:0',
            'rooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'floor' => 'nullable|integer|min:0',
            'total_floors' => 'nullable|integer|min:0',
            'construction_year' => 'nullable|integer|min:1800|max:' . (date('Y') + 5),
            'status_type' => 'nullable|in:for_sale,for_rent,sold,rented',
            'furnished' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'media_files.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,mp4,mov,avi|max:10240',
            'delete_media.*' => 'nullable|integer|exists:estate_media,id',
            'media_order.*' => 'nullable|integer|min:0',
        ];

        // Get available languages dynamically
        $languages = \App\Models\Language::all();
        
        foreach ($languages as $language) {
            $rules["title.{$language->code}"] = 'required|string|max:255';
            $rules["description.{$language->code}"] = 'nullable|string';
            $rules["address.{$language->code}"] = 'nullable|string|max:255';
            $rules["location.{$language->code}"] = 'nullable|string|max:255';
            $rules["slug.{$language->code}"] = 'nullable|string|max:255';
            $rules["seo_keywords.{$language->code}"] = 'nullable|string';
            $rules["seo_description.{$language->code}"] = 'nullable|string';
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        $messages = [
            'price.numeric' => 'Qiymət rəqəm olmalıdır.',
            'price.min' => 'Qiymət mənfi ola bilməz.',
            'area.numeric' => 'Sahə rəqəm olmalıdır.',
            'area.min' => 'Sahə mənfi ola bilməz.',
            'rooms.integer' => 'Otaq sayı tam rəqəm olmalıdır.',
            'bathrooms.integer' => 'Vanna sayı tam rəqəm olmalıdır.',
            'floor.integer' => 'Mərtəbə tam rəqəm olmalıdır.',
            'total_floors.integer' => 'Ümumi mərtəbə tam rəqəm olmalıdır.',
            'construction_year.integer' => 'Tikinti ili tam rəqəm olmalıdır.',
            'construction_year.min' => 'Tikinti ili 1800-dən kiçik ola bilməz.',
            'construction_year.max' => 'Tikinti ili gələcək ildən çox ola bilməz.',
            'type.in' => 'Seçilən əmlak növü etibarsızdır.',
            'status_type.in' => 'Seçilən status etibarsızdır.',
            'image.image' => 'Yüklənən fayl şəkil olmalıdır.',
            'image.mimes' => 'Şəkil jpeg, png, jpg, gif və ya webp formatında olmalıdır.',
            'image.max' => 'Şəkil maksimum 2MB ola bilər.',
            'media_files.*.mimes' => 'Media faylları jpeg, png, jpg, gif, webp, mp4, mov və ya avi formatında olmalıdır.',
            'media_files.*.max' => 'Media faylları maksimum 10MB ola bilər.',
        ];

        $languages = \App\Models\Language::all();
        
        foreach ($languages as $language) {
            $messages["title.{$language->code}.required"] = "Başlıq sahəsi ({$language->title}) tələb olunur.";
            $messages["title.{$language->code}.max"] = "Başlıq ({$language->title}) maksimum 255 simvol ola bilər.";
            $messages["description.{$language->code}.string"] = "Təsvir ({$language->title}) mətn olmalıdır.";
            $messages["address.{$language->code}.max"] = "Ünvan ({$language->title}) maksimum 255 simvol ola bilər.";
            $messages["location.{$language->code}.max"] = "Məkan ({$language->title}) maksimum 255 simvol ola bilər.";
            $messages["slug.{$language->code}.max"] = "Slug ({$language->title}) maksimum 255 simvol ola bilər.";
            $messages["seo_keywords.{$language->code}.string"] = "SEO açar sözlər ({$language->title}) mətn olmalıdır.";
            $messages["seo_description.{$language->code}.string"] = "SEO təsvir ({$language->title}) mətn olmalıdır.";
        }

        return $messages;
    }

    /**
     * Get custom attribute names for validator errors.
     */
    public function attributes(): array
    {
        $attributes = [
            'price' => 'Qiymət',
            'area' => 'Sahə',
            'rooms' => 'Otaq sayı',
            'bathrooms' => 'Vanna sayı',
            'floor' => 'Mərtəbə',
            'total_floors' => 'Ümumi mərtəbə',
            'construction_year' => 'Tikinti ili',
            'type' => 'Əmlak növü',
            'status_type' => 'Status',
            'image' => 'Şəkil',
        ];

        // Get available languages dynamically for attribute names
        $languages = \App\Models\Language::all();
        
        foreach ($languages as $language) {
            $attributes["title.{$language->code}"] = "Başlıq ({$language->title})";
            $attributes["description.{$language->code}"] = "Təsvir ({$language->title})";
            $attributes["address.{$language->code}"] = "Ünvan ({$language->title})";
            $attributes["location.{$language->code}"] = "Məkan ({$language->title})";
            $attributes["slug.{$language->code}"] = "Slug ({$language->title})";
            $attributes["seo_keywords.{$language->code}"] = "SEO açar sözlər ({$language->title})";
            $attributes["seo_description.{$language->code}"] = "SEO təsvir ({$language->title})";
        }

        return $attributes;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Convert checkbox values to boolean
        $this->merge([
            // 'furnished' => $this->has('furnished') ? true : false,
        ]);
    }
}