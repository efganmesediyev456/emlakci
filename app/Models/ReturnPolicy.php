<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnPolicy extends BaseModel
{
    use HasFactory;
    public $translatedAttributes = ['title', 'description','seo_description','seo_keywords'];
}
