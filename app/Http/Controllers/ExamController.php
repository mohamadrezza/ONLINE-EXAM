<?php

namespace App\Http\Controllers;

use App\Exam;
use App\Lesson;
use Carbon\Carbon;
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

        Lesson::where('id', $lessonId)
            ->where('teacher_id', Auth::id())
            ->firstOrFail();
        try {
            Exam::create([
                'lesson_id' => $lessonId,
                'teacher_id' => Auth::id(),
                'duration' => $request->duration,
                'started_at' => Carbon::createFromTimestamp($request->startedAt),
                'title' => $request->title,
                'finished_at' => Carbon::createFromTimestamp($request->startedAt)->addMinutes($request->duration)
            ]);
            return $this->respondWithTemplate(true, [], 'امتحان ثبت شد');
        } catch (\Exception $e) {
            return $this->respondWithTemplate(false, [], $e);
        }
    }
    function selectExamQuestions($lessonId,$examId,Request $request)
    {
        $request->validate([
            'questions' => 'required'
        ]);
        $exam = Exam::where('lesson_id',$lessonId)
            ->where('id',$examId)->firstOrFail();
        $questionIds = $request->questions;
        return $questionIds;
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
