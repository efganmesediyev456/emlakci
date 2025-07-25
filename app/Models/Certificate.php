<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Certificate extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    public $casts = [
        'date' => 'datetime',
    ];

    public $translatedAttributes = ['title'];

}
