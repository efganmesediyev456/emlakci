<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleForm extends Model
{
    use HasFactory;
    public $guarded = [];

    public function files(){
        return $this->hasMany(SaleFormFile::class);
    }
}
