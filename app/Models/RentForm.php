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
}
