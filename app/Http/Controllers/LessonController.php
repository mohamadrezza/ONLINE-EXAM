<?php

namespace App\Http\Controllers;

use App\User;
use App\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\LessonsResource;

class LessonController extends Controller
{
    function getTeacherLessons()
    {
        $lessons = Lesson::where('teacher_id', Auth::id())
            ->latest('created_at')
            ->paginate(10);

        return $this->respondWithTemplate(true, $lessons);
    }
    function getById($id)
    {
        $lesson = Lesson::where('id', $id)->firstOrFail();
        return $lesson;
    }
    function getAll(Request $request)
    {
        try {
            $lessons = Lesson::when($request->title, function ($q, $title) {
                return $q->where('title', $title);
            })->with(['teacher' => function ($q) {
                return $q->select('name', 'id');
            }]);
            if ($request->has('teacher')) {
                $teachers = User::where('role', 'teacher')->where('name', 'like', "%" . $request['teacher'] . "%")
                    ->orWhere('email', $request['teacher'])
                    ->get();
                $lessons->whereIn('teacher_id', $teachers);
            }


            $result = $lessons
                ->orderBy('created_at', $request->order ?? 'desc')
                ->paginate($request->perPage ?? 20);


            return $this->respondWithTemplate(true, LessonsResource::collection($result));
        } catch (\Exception $e) {
            return $this->respondWithTemplate(false, [], $e->getMessage());
        }
    }
}
