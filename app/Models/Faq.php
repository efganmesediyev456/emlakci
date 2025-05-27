<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Faq extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    public $translatedAttributes = ['title', 'description'];
    
    protected $fillable = ['icon', 'status', 'order'];

}