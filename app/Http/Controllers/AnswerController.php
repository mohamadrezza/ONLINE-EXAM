<?php

namespace App\Http\Controllers;

use App\Question;
use App\QuestionAnswers;
use Illuminate\Http\Request;
use App\Http\Resources\QuestionAnswersResource;

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
                    'is_correct' => $answer['isCorrect'],
                    'answer' => $answer['answer']
                ]);
            }
            return $this->respondWithTemplate(true, [], 'پاسخ سوالات ثبت شد');
        } catch (\Exception $e) {
            return $this->respondWithTemplate(false, [], $e);
        }
    }
    function get($id, $questionId){
        try {
            $answers = QuestionAnswers::where('question_id',$questionId)->get();
            $data=QuestionAnswersResource::collection($answers);
            return $this->respondWithTemplate(true,$data);
        } catch (\Exception $e) {
            return $this->respondWithTemplate(false, [], $e);
        }
    }
}
