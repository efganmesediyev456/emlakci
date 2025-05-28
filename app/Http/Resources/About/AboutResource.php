<?php

namespace App\Http\Resources\About;

use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AboutResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

     public function toArray(Request $request): array
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
            'title' => $this->title,
            'indicator_title1' => $this->indicator_title1,
            'description' => $this->description,
            'indicator_title2' => $this->indicator_title2,
            'indicator_description' => $this->indicator_description,
            'choose_why_title' => $this->choose_why_title,
            'choose_why_desc' => $this->choose_why_desc,
            'seo_description' => $this->seo_description,
            'seo_keywords' => $data,
            'image' => url('/storage/'.$this->image),
            'image2' => url('/storage/'.$this->image2),
            'image3' => url('/storage/'.$this->image3),
            'foreign_advertisements_count' => $this->foreign_advertisements_count,
            'local_advertisements_count' => $this->local_advertisements_count,
            'yearly_activity' => $this->yearly_activity,
        ];
    }



    private function getTranslatedSlugs(): array
    {
        $languages = Language::pluck('code')->toArray();

        $slugs = [];
        foreach ($languages as $lang) {
            $slugs[$lang] = $this->getTranslation('slug', $lang) ?? null;
        }

        return $slugs;
    }

}
