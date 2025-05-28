<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OurOnMapResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $array = json_decode($this->seo_keywords, true);
        $data = [];
        if(is_array($array) and count($array)){
           foreach ($array as $key => $value) {
               $value['id']=$key+1;
               $data[] = $value;
           }
        }
        return [
            'id' => $this->id,
            'contact_title1' => $this->contact_title1,
            'contact_title2' => $this->contact_title2,
            'title' => $this->title,
            'contact_content1' => $this->contact_content1,
            'contact_content2' => $this->contact_content2,
            'address' => $this->address,
            'image' => $this->image ? url('storage/' . $this->image) : null,
            'seo_keywords'=>$data,
            'seo_description'=>$this->seo_description,
            'email'=>$this->email,
            'phone'=>$this->phone,
        ];
    }
}