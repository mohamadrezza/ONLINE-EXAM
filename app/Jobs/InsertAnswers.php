<?php

namespace App\Jobs;

use App\StudentAnswer;
use App\StudentResult;
use App\QuestionAnswers;
use Illuminate\Support\Arr;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class InsertAnswers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $tries = 2;

    private $data , $userId, $examId;
    public function __construct($data, $userId, $examId)
    {
        $this->data = $data;
        $this->userId = $userId;
        $this->examId = $examId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $hash = [];
        foreach ($this->data as $record) {
            DB::table('student_answers')->insert([
                'student_id'=>$this->userId,
                'question_id'=>$record['questionId'],
                'exam_id'=>$this->examId,
                'answer_hash'=>$record['hash'],
            ]);
        }
        StudentResult::create([
            'exam_id' => $this->examId,
            'student_id' => $this->userId,
            'result' => QuestionAnswers::whereIn('question_id', Arr::pluck($this->data, 'questionId'))
                ->whereIn('hash', Arr::pluck($this->data, 'hash'))
                ->sum('is_correct')
        ]);
    }
}
