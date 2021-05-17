<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Lesson;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LessonController extends Controller
{
    function create(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'teacherEmail' => 'required|string|email',
        ]);

        $teacher = User::where('role', User::ROLE['teacher'])
            ->whereEmail($request->teacherEmail)
            ->firstOrFail();

        Lesson::create([
            'teacher_id' => $teacher->id,
            'title' => $request->title,
            // 'unit' => $request->unit,
            'description' => $request->descripton
        ]);
        return $this->respondWithTemplate(true, [], 'درس ثبت شد');
    }
    function getAll()
    {
        try {
            $lessons = Lesson::with(['teacher' => function ($q) {
                return $q->select(['name']);
            }])->orderBy('created_at', 'desc')
                ->paginate(20);
            return $this->respondWithTemplate(true, [], $lessons);
        } catch (\Exception $e) {
            return $this->respondWithTemplate(false, [], $e->getMessage());
        }
    }
    
}
