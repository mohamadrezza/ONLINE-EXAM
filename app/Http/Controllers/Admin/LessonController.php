<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Lesson;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LessonsResource;

class LessonController extends Controller
{
    function create(Request $request)
    {

        $request->validate([
            'title' => 'required|string',
            'teacherEmail' => 'required|string|email',
        ]);

        $teacher = User::where('role', 'teacher')
            ->whereEmail($request->teacherEmail)
            ->first();
        if (!$teacher) return $this->respondWithTemplate(false, [], 'استاد مورد نظر پیدا نشد');
        Lesson::create([
            'teacher_id' => $teacher->id,
            'title' => $request->title,
            'unit' => $request->unit,
            'description' => $request->description,
            'cover' => $request->cover
        ]);
        return $this->respondWithTemplate(true, [], 'درس ثبت شد');
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
