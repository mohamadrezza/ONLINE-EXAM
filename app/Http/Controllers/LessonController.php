<?php

namespace App\Http\Controllers;

use App\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    function getTeacherLessons()
    {
        $lessons = Lesson::where('teacher_id', Auth::id())
            ->latest('created_at')
            ->paginate();

        return $this->respondWithTemplate(true, [], $lessons);
    }
    function getById($id)
    {
        $lesson = Lesson::where('id', $id)->firstOrFail();
        return $lesson;
    }
    function getAll()
    {
        try {
            $lessons = Lesson::with(['teacher' => function ($q) {
                return $q->select(['id', 'name']);
            }])->orderBy('created_at', 'desc')
                ->paginate(20);
            return $this->respondWithTemplate(true, [], $lessons);
        } catch (\Exception $e) {
            return $this->respondWithTemplate(false, [], $e->getMessage());
        }
    }
}
