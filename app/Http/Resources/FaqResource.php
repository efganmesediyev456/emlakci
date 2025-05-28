<?php

namespace App\Http\Resources;

use App\Models\Language;
use Illuminate\Http\Resources\Json\JsonResource;

class FaqResource extends JsonResource
{
    protected $index;

    public function __construct($resource, $index = 1)
    {
        parent::__construct($resource);
        $this->index = $index;
    }

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'index' => str_pad($this->index, 2, '0', STR_PAD_LEFT),
        ];
    }
}
