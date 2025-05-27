<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LittleVideoRolicResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'video_url' => url($this->video_url),
            'thumbnail'=>url( $this->thumbnail),
            'date'=>$this->date->translatedFormat('d F Y'),
        ];
    }
}