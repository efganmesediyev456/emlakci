<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasTranslations;

class Exam extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'subcategory_id',
        'duration',
        'date',
        'type',
    ];

    protected $dates = [
        'date',
    ];

    public $translatedAttributes = [
        'title',
        'subtitle',
        'megasubtitle',
        'slug'
    ];

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function getTranslationRelationKey(): string
    {
        return 'exam_id';
    }

    public function questions()
    {
        return $this->hasMany(ExamQuestion::class);
    }
}