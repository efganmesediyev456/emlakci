<?php

namespace App\Http\Resources\Regulations;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TranslationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public static $wrap = null;


    public function toArray(Request $request): array
    {
        return [
            $this->key => $this->value
        ];
    }
}
