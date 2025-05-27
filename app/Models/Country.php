<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Country extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    public $translatedAttributes = ['title'];
    
    protected $fillable = ['status', 'order'];


    public function cities(){
        return $this->hasMany(City::class, 'country_id');
    }
}