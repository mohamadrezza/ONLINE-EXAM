<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    function create(Request $request)
    {
        $request->validate([
            'question'=>'required|string'
        ]);
        Question::create([
            'user_id'=>auth()->id,
            'question_text'=>$request->question,
            'attachment'=>$request->attachment
        ]);
    }
    function getQuestionsByExamId($id)
    {
    }
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
