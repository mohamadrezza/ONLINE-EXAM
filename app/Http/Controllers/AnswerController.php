<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    function create($id, $questionId, $request)
    {
        $question = Question::where('id', $questionId)
            ->where('user_id', auth()->id())
            ->where('lesson_id', $id)
            ->firstOrFail();

        $question->saveMany();
    }
}
