<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuizQuestionsResource extends JsonResource
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
            'question'=>$this->question_text,
            'answers' => $this->answers->map(function ($i) {
                return ['text' => $i->answer, 'hash' => $i->hash];
            }),
        ];
    }
}
