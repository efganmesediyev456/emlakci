<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GalleryPhoto extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    public $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];
    public $table = 'gallery_photos';
    public $guarded = [];
    public $translatedAttributes = ['title','seo_keywords','seo_description', 'slug'];

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('/default.webp');
        }
        return url('storage/'.$this->image);
    }
    public function media()
    {
        return $this->hasMany(GalleryPhotoMedia::class, 'gallery_photo_id')->orderBy('order');
    }
}
