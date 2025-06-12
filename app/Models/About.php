<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends BaseModel
{
    use HasFactory;

    public $guarded = [];

    public $translatedAttributes = [
        'choose_why_title', 
        'title', 
        'seo_keywords', 
        'seo_description', 
        'choose_why_desc',
        'indicator_title1',
        'indicator_title2',
        'indicator_description',
        'description',
        'choose_why_desc',
        'choose_why_title',
        'our_advantages',
    ];

    public function translations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AboutTranslation::class, 'about_id');
    }

    public function getTranslationRelationKey(): string
    {
        return 'about_id';
    }
}