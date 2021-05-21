<?php

namespace App\Jobs;

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

    private $data,$userId,$examId;
    public function __construct($data, $userId,$examId)
    {
        $this->data=$data;
        $this->userId=$userId;
        $this->examId=$examId;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->data as $record) {
            DB::table('student_answers')->insert([
                'student_id'=>$this->userId,
                'question_id'=>$record['id'],
                'exam_id'=>$this->examId,
                'answer'=>$record['answer'],
            ]);

        }
    }
}
