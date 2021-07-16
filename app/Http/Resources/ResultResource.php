<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ResultResource extends JsonResource
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
            'result' => $this->result,
            'exam' => $this->exam->title,
            'teacher' => $this->exam->teacher->name,
            'startedAt' => $this->exam->started_at->timestamp
            // 'finishedAt' => $this->finished_at->timestamp
        ];
    }
}
