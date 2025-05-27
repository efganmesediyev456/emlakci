<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class TypeEstate extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    public $translatedAttributes = ['title'];
    
    protected $fillable = ['status', 'order'];
}