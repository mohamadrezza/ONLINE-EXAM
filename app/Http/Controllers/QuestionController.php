<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    function create($id, Request $request)
    {
        $request->validate([
            'question' => 'required|string'
        ]);
        try {
            Question::create([
                'lesson_id' => $id,
                'user_id' => auth()->id(),
                'question_text' => $request->question,
                'attachment' => $request->attachment
            ]);
            return $this->respondWithTemplate(true, [], 'سوال شما ثبت شد, درصورت صلاح دید استاد تایید میشود');
        } catch (\Exception $e) {
            return $this->respondWithTemplate(false, [], $e);
        }
    }
    function getAllByLessonId($id, Request $request)
    {
        $questions = Question::where('lesson_id', $id)
            ->with('user')
            ->orderBy('created_at', $request->order ?? 'desc')
            ->paginate(20);
        return $questions;
    }
    // function getQuestionsByExamId($id)
    // {
    // }
    function acceptQuestionByTeacherById($id)
    {
    }
    function selectExamQuestions(Request $request)
    {
        $request->validate([
            'questions' => 'required|array'
        ]);
        $questionIds = $request->questions;
    }
}
