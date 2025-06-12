<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentForm extends Model
{
    use HasFactory;
    public $guarded = [];

    public function files(){
        return $this->hasMany(RentFormFile::class);
    }

     public function typeEstate(){
        return $this->belongsTo(TypeEstate::class);
    }

    public function country(){
        return $this->belongsTo(Country::class, 'country_id');
    }
     
    public function city(){
        return $this->belongsTo(City::class, 'city_id');
    }

}
