<?php

namespace App\Http\Controllers;

use App\Exam;
use App\Lesson;
use App\Question;
use Carbon\Carbon;
use App\ExamSession;
use App\Helpers\Constants;
use Illuminate\Http\Request;
use App\Services\Exam\ExamService;
use App\Http\Resources\QuizResource;
use App\Jobs\InsertAnswers;
use App\QuestionAnswers;
use App\StudentAnswer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExamController extends Controller
{
    function create($lessonId, Request $request)
    {
        $request->validate([
            'duration' => 'required',
            'title' => 'required',
            'startedAt' => 'required'
        ]);

        Lesson::where('id', $lessonId)
            ->where('teacher_id', Auth::id())
            ->firstOrFail();
        try {
            Exam::create([
                'lesson_id' => $lessonId,
                'teacher_id' => Auth::id(),
                'duration' => $request->duration,
                'started_at' => Carbon::createFromTimestamp($request->startedAt),
                'title' => $request->title,
                'finished_at' => Carbon::createFromTimestamp($request->startedAt)->addMinutes($request->duration)
            ]);
            return $this->respondWithTemplate(true, [], 'امتحان ثبت شد');
        } catch (\Exception $e) {
            return $this->respondWithTemplate(false, [], $e);
        }
    }
    function selectExamQuestions($lessonId, $examId, Request $request)
    {

        $request->validate([
            'questions' => 'required|array'
        ]);

        $exam = Exam::where('lesson_id', $lessonId)
            ->where('id', $examId)->firstOrFail();
        try {
            //for more Assurance about inputs
            $questionIds = Question::whereIn('id', $request->questions)
                ->where('is_accepted', 1)
                ->pluck('id');

            $exam->questions()->syncWithoutDetaching($questionIds);
            return $this->respondWithTemplate(true, [], 'سوالات امتحان ثبت شد');
        } catch (\Exception $e) {
            return $this->respondWithTemplate(false, [], $e);
        }
    }


    function getAll()
    {
    }

    //teacher only
    function getById()
    {
        $exam = Exam::whereId(1)
            ->with(['questions.answers', 'lesson'])
            ->firstOrFail();

        return new QuizResource($exam);
    }
    function start($lessonId, $examId)
    {
        $exam = Exam::whereId($examId)
            ->where('lesson_id', $lessonId)
            ->with(['questions.answers', 'lesson'])
            ->firstOrFail();
        try {
            $service = new ExamService($exam, Auth::id());
            $service->checkExamAvailability();
            ExamSession::create([
                'student_id' => Auth::id(),
                'exam_id' => $examId,
                'started_at' => now()
            ]);
            return new QuizResource($exam);
        } catch (\Exception $e) {
            return $this->respondWithTemplate(false, [], $e->getMessage());
        }
    }
    function finish($lessonId, $examId, Request $request)
    {
        $request->validate([
            'answers' => 'required|array'
        ]);
        $exam = Exam::whereId($examId)
            ->where('lesson_id', $lessonId)
            ->firstOrFail();

        $examSession = ExamSession::where('exam_id', $examId)
            ->where('student_id', Auth::id())
            ->firstOrFail();
        DB::beginTransaction();

        try {

            // $examFinishTime = Carbon::parse($exam->finished_at)
            //     ->addMinutes(Constants::EXAM_EXTRA_TIME);
            // if (now() > $examFinishTime)
            //     return $this->respondWithTemplate(false, [], 'too late too late', 406);
            $examSession->update([
                'finished_at' => now()
            ]);

            dispatch(new InsertAnswers($request->answers, Auth::id(), $examId));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->respondWithTemplate(false, [], $e->getMessage());
        }
    }

    function result($lessonId, $examId)
    {
        $userId = Auth::id();
        $studentAnswers = StudentAnswer::where('student_id', $userId)
            ->where('exam_id', $examId)
            ->pluck('answer_hash');
        $correctAnswers = QuestionAnswers::whereIn('hash', $studentAnswers)
            ->sum('is_correct');
        return $correctAnswers;
    }
}

