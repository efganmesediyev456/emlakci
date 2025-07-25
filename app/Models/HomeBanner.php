<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HomeBanner extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    
    public $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];

    public $guarded = [];
    public $translatedAttributes = ['title', 'description'];

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('/default.webp');
        }
        
        return url('storage/'.$this->image);
    }
}