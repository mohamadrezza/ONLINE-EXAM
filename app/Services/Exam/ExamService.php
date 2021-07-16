<?php

namespace App\Services\Exam;

use App\Exam;
use Exception;
use Carbon\Carbon;
use App\ExamSession;
use App\Helpers\Constants;

class ExamService
{
    private $exam;
    private $userId;


    function __construct(Exam $exam, $userId)
    {
        $this->exam = $exam;
        $this->userId = $userId;
    }

    function checkExamAvailability()
    {
        // $this->checkTime();
        $this->canUserTakeExam();
    }
    public function canUserFinishExam()
    {
        $examFinishTime = Carbon::parse($this->exam->finished_at)
            ->addMinutes(Constants::EXAM_EXTRA_TIME);
        if (now() > $examFinishTime)
            throw new Exception('too late too late');
    }
    private function checkTime()
    {
        if (
            now() > $this->exam->finished_at ||
            now() < Carbon::parse($this->exam->started_at)

        )
            throw new Exception('لطفا در زمان امتحان حاضر شوید');
    }
    private function canUserTakeExam()
    {
        $finishedSession = ExamSession::where('student_id', $this->userId)
            ->where('exam_id', $this->exam->id)
            ->whereNotNull('finished_at')
            ->exists();
        $examSessionCount = ExamSession::where('student_id', $this->userId)
            ->where('exam_id', $this->exam->id)
            ->count();

        if (
            $finishedSession ||
            $examSessionCount >= Constants::TIMES_ALLOWED_PARTICIPATE_TEST
        )
            throw new Exception('شما دیگر مجاز به شرکت در امتحان نیستید');
    }
}
