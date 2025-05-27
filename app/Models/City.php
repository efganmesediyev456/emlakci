<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class City extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    public $translatedAttributes = ['title'];
    
    protected $fillable = ['country_id', 'status', 'order'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}