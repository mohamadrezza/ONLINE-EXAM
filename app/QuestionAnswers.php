<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionAnswers extends Model
{
    use HasFactory;
    protected $fillable=[
        'question_id',
        'answer',
        'is_correct'
    ];
    function question()
    {
        return $this->belongsTo(Question::class,'question_id');
    }
}