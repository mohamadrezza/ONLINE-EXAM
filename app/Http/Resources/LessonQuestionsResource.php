<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LessonQuestionsResource extends JsonResource
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
            'id' => $this->id,
            'question' => $this->question_text,
            'attachment' => $this->attachment,
            'createdAt' => isset($this->created_at) ? $this->created_at->timestamp : null,
            'user' => $this->user->name,
            'isAccepted'=>$this->is_accepted
        ];
    }
}
