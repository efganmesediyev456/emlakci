<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstateMedia extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'file',
        'status',
        'order',
        'estate_id'
    ];

    public function estate()
    {
        return $this->belongsTo(Estate::class);
    }

    public function getFileUrlAttribute()
    {
        if (!$this->file) {
            return asset('/default.webp');
        }
        
        return url('storage/'.$this->file);
    }
}