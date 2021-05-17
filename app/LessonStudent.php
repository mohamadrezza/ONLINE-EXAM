<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonStudent extends Model
{
    use HasFactory;
    protected $table = 'lesson_student';
    
    protected $fillable = [
        'lesson_id',
        'student_id',
    ];
}
