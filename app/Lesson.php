<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'teacher_id',
        'description',
        "unit",
        "cover"
    ];
    function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
    function questions()
    {
        return $this->hasMany(Question::class,'lesson_id');
    }

}
