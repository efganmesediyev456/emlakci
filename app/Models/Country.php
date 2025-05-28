<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Country extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    public $translatedAttributes = ['title'];
    
    protected $fillable = ['status', 'order', 'icon','number'];


    public function cities(){
        return $this->hasMany(City::class, 'country_id');
    }

    
    public function scopeStatus(Builder $query){
        return $query->where("status",1);
    }

     public function scopeOrder(Builder $query){
        return $query->orderBy("id","desc");
    }

}