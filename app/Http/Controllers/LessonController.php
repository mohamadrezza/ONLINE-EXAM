<?php

namespace App\Http\Controllers;

use App\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    function getAllForTeacher()
    {
        $lessons = Lesson::where('teacher_id',Auth::id())->get();
        return $lessons;
    }
    function getByLessonId($id)
    {
        $lesson= Lesson::where('id',$id)->firstOrFail();
        return $lesson;
    }
    
}
