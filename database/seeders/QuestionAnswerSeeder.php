<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('question_answers')->insert([
            'question_id' =>rand(1,2),
            'answer' =>Str::random(20),
            'hash ' =>Str::random(10),
        ]);
    }
}
