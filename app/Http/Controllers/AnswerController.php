<?php

namespace App\Http\Controllers;

use App\Question;
use App\QuestionAnswers;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    function create($id, $questionId, Request $request)
    {
        $request->validate([
            'answers' => 'required'
        ]);
        Question::where('id', $questionId)
            ->where('user_id', auth()->id())
            ->where('lesson_id', $id)
            ->firstOrFail();
            
        try {
            foreach ($request->answers as $answer) {
                QuestionAnswers::create([
                    
                    'question_id' => $questionId,
                    'is_correct' => $answer['is_correct'],
                    'answer' => $answer['answer']
                ]);
            }
            return $this->respondWithTemplate(true, [], 'پاسخ سوالات ثبت شد');
        } catch (\Exception $e) {
            return $this->respondWithTemplate(false, [], $e);
        }
    }
}
