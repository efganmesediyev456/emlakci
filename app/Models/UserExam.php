<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserExam extends Model
{
    use HasFactory;

    public $guarded = [];
    use SoftDeletes;


    public $casts = [
        "created_at"=>"datetime"
    ];

    public function examQuestionOption(){
        return $this->belongsTo(ExamQuestionOption::class,'answer_id');
    }

    public function exam(){
        return $this->belongsTo(Exam::class);
    }
}
