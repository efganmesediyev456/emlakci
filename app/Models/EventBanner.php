<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventBanner extends BaseModel
{
    use HasFactory;

    public $guarded = [];

    public $translatedAttributes = [
        'title',
        'subtitle',
        'description'
    ];

    public function translations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(EventBannerTranslation::class, 'event_banner_id');
    }

    public function getTranslationRelationKey(): string
    {
        return 'event_banner_id';
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('/default.webp');
        }
        
        return url('storage/'.$this->image);
    }
}