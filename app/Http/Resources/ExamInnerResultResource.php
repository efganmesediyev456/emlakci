<?php

namespace App\Http\Resources;

use App\Models\Language;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ExamQuestionOptionResource;
use App\Http\Resources\ExamQuestionOptionResultResource;

class ExamInnerResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->question_text,
            'type' => $this->type,
            'variants' => $this->when(
                $this->type === 1, 
                ExamQuestionOptionResultResource::collection($this->options) 
            ),
        ];
    }
}