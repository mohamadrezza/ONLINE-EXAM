<?php

namespace App\Http\Controllers;

use App\Exam;
use App\Http\Resources\LessonQuestionsResource;
use App\Lesson;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    function create($id, Request $request)
    {
        $request->validate([
            'question' => 'required|string'
        ]);
        try {
           $question= Question::create([
                'lesson_id' => $id,
                'user_id' => auth()->id(),
                'question_text' => $request->question,
                'attachment' => $request->attachment
            ]);
            return $this->respondWithTemplate(true, [], ['questionId'=>$question->id]);
        } catch (\Exception $e) {
            return $this->respondWithTemplate(false, [], $e->getMessage());
        }
    }
    function getAllByLessonId($id, Request $request)
    {
        $questions = Question::where('lesson_id', $id)
            ->with('user')
            ->orderBy('created_at', $request->order ?? 'desc')
            ->paginate($request->perPage ?? 20);
        $data = LessonQuestionsResource::collection($questions);
        return $this->respondWithTemplate(true, $data);
    }

    function accept($id, $questionId)
    {
        Lesson::where('id', $id)
            ->where('teacher_id', auth()->id())
            ->firstOrFail();
        $question = Question::where('id', $questionId)
            ->firstOrFail();
        $question->update([
            'is_accepted' => 1
        ]);
        return $this->respondWithTemplate(true, [], 'تایید شد');
    }
}
