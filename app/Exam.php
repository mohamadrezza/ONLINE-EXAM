<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable =[
        'teacher_id',
        'lesson_id',
        'title',
        'duration',
        'description',
        'started_at',
        'finished_at',
    ];
    
    function questions()
    {
        return $this->belongsToMany(
            Question::class,
            'exam_questions',
            'exam_id',
            'question_id'
        );
    }
}
