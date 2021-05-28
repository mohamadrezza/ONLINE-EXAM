<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    
    protected $fillable=[
        'lesson_id',
        'user_id',
        'is_accepted',
        'question_text',
        'attachment'
    ];

    function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    function answers()
    {
        return $this->hasMany(QuestionAnswers::class,'question_id')->inRandomOrder();
    }
}
