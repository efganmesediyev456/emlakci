<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstateTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'title', 
        'description', 
        'slug', 
        'seo_keywords', 
        'seo_description', 
        'address', 
        'location'
    ];
}