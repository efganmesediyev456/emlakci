<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SiteSettingResource extends JsonResource
{
    
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'header_logo' => url('/storage/'.$this->header_logo),
            'footer_logo' => url('/storage/'.$this->footer_logo),
            'favicon' => url('/storage/'.$this->favicon),
            'whatsapp_number' => $this->whatsapp_number,
        ];
    }
}