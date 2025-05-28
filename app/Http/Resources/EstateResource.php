<?php

namespace App\Http\Resources;

use App\Models\EstateMedia;
use App\Models\LangTranslation;
use App\Models\Language;
use Illuminate\Http\Resources\Json\JsonResource;

class EstateResource extends JsonResource
{

    private function getTranslatedSlugs(): array
    {
        $languages = Language::pluck('code')->toArray();

        $slugs = [];
        foreach ($languages as $lang) {
            $slugs[$lang] = $this->translate($lang)->slug ?? null;
        }

        return $slugs;
    }
    public function toArray($request)
    {
       
        $rooms_info = LangTranslation::where('key','rooms_info')?->whereLocale(app()->getLocale())?->first()?->value;
        $mortgage_info = LangTranslation::where('key','mortgage_info')?->whereLocale(app()->getLocale())?->first()?->value;
        $mortgage_info = LangTranslation::where('key','mortgage_info')?->whereLocale(app()->getLocale())?->first()?->value;
        $has_extract_info = LangTranslation::where('key','has_extract_info')?->whereLocale(app()->getLocale())?->first()?->value;
        $from_starting = LangTranslation::where('key','from_starting')?->whereLocale(app()->getLocale())?->first()?->value;

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
            'country_city_district'=>$this->country?->title.'-'.$this->city?->title.'-'.$this->district,
            'floor_info' => $this->floor . '/' . $this->total_floors,
            'rooms_info' => $this->rooms.' '.$rooms_info,
            "mortgage"=>(bool)$this->mortgage,
            "mortgage_info"=>$mortgage_info,
            'has_extract' => (bool) $this->has_extract,
            'has_extract_info' => $has_extract_info,
            'subtitle' => $this->subtitle,
            'price' => (int)$this->price.' '.$from_starting,
            'image' => url('storage/'.$this->image),
            'media' => $this->whenLoaded('media', function() {
                            return $this->media->prepend(new EstateMedia([
                                "file"=>$this->image
                            ]))->map(function($media, $key) {
                                return [
                                    'id' => $key+1,
                                    'url' => url('storage/'.$media->file),
                                ];
                            });
                        }),
            'date' => $this->created_at->translatedFormat('d F Y', app()->getLocale()),
            'slug' => $this->getTranslatedSlugs(),
            'seo_keywords' => $data,
            'seo_description' => $this->seo_description,
            'type_purchase' => $this->typePurchase?->title,
            'type_purchase_icon' => url('storage/'.$this->typePurchase?->icon),
            'type_estate' => $this->typeEstate?->title,
            'type_estate_icon' =>url('storage/'.$this->typeEstate?->icon),
            'address' => $this->address,
            'area_info' => (int)$this->area . ' m²',
            'description' => $this->description,
            'properties' => $this->whenLoaded('properties', function() {
                return $this->properties->map(function($property) {
                    return [
                        'id' => $property->id,
                        'title' => $property->title,
                        'icon' => url('storage/',$property->icon),
                    ];
                });
            }),
            'is_new' => $this->is_new,
            'call_number' => $this->call_number,
            'whatsapp_number' => $this->whatsapp_number,
            'map' => $this->map
        ];
    }
}