<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OurOnMap extends BaseModel
{
    use HasFactory;
    public $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];

    public $guarded = [];
    public $translatedAttributes = ['seo_keywords','seo_description','address',
     'contact_title1', 'contact_content1' , 'contact_title2','contact_content2','title'];

    public function media(){
        return $this->hasMany(ProductMedia::class);
    }
}
