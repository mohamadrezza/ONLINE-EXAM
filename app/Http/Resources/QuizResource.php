<?php

namespace App\Http\Resources;

use App\Http\Resources\QuizQuestionsResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'teacher'=>$this->teacher->name,
            'lesson'=>$this->lesson->title,
            'startedAt'=>now('utc')->timestamp,
            'duration'=>Carbon::parse($this->finished_at)->diffInMinutes(now()),
            'questions'=>QuizQuestionsResource::collection($this->questions)
        ];
    }
}
