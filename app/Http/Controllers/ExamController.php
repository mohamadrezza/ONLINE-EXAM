<?php

namespace App\Http\Controllers;

use App\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    function create($lessonId, Request $request)
    {
        $request->validate([
            'duration' => 'required',
            'title' => 'required',
            'startedAt' => 'required'
        ]);
        Exam::create([
            'lesson_id'=>$lessonId,
            'teacher_id' => Auth::id(),
            'duration' => $request->duration,
            'started_at' => $request->startedAt,
            'title' => $request->title
        ]);
    }
    function getAll()
    {
    }
    function getById()
    {
    }
    function start()
    {
    }
    function finish()
    {
    }
}
