<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lesson;
use Carbon\Carbon;

class LessonController extends Controller
{
    function create(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'teacherEmail' => 'required|string|email',
        ]);

        $teacher = User::where('role', User::ROLE['teacher'])->whereEmail($request->teacherEmail)->firstOrFail();

        Lesson::create([
            'teacher_id' => $teacher->id,
            'title' => $request->title,
            'started_at' => $request->timestamp ? Carbon::createFromTimestamp($request->timestamp) : null
        ]);
    }
    function getAll()
    {
        $lessons = Lesson::query()->orderBy('created_at', 'desc')
            ->paginate(20);
        return $this->respondWithTemplate(true,[],$lessons);
    }
}
