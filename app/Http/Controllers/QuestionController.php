<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuestionController extends Controller
{
    function create(Request $request)
    {
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
