<?php

namespace App\Http\Resources\Products;

use App\Models\Language;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function seoKeywords($values){
        $array = json_decode($values, true);
        $data = [];
        if(is_array($array) and count($array)){
            foreach ($array as $key => $value) {
                $value['id']=$key+1;
                $data[] = $value;
            }
        }
        return $data;
    }

    public function toArray(Request $request): array
    {
        // Paginate products - you can adjust the page size (15) as needed
//        $paginatedProducts = $this->products()->paginate(15);

        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->getTranslatedSlugs($this),
            'seo_keywords'=>$this->seoKeywords($this->seo_keywords),
            'seo_description'=>$this->seo_description,
            'image' => url('storage/'.$this->image),
            'description' =>$this->description,
            'subcategories' => $this->subCategories->map(function($item){
                return [
                        "id"=>$item->id,
                        "title"=>$item->title,
                        "image"=>url('/storage/'.$item->image),
                        'hasActiveSubscription'=>auth('api')->user() and auth('api')->user()->hasActiveSubscription($item),
                        'hasTopic'=>$item->topics()?->count() > 0,
                        'topicIcon' => $item->topics()->first()?->icon ? url('storage/'.$item->topics()->first()?->icon) : null,
                        'hasVideo'=>$item->videos()?->count() > 0,
                        'videoIcon' => $item->videos()->first()?->thumbnail ? url('storage/'.$item->videos()->first()?->thumbnail) : null,
                        'hasExam'=>$item->tests()?->count() > 0,
                        'examIcon' => $item->tests()->first()?->icon ? url('storage/'.$item->tests()->first()?->icon) : null,
                        'hasEssayExample'=>$item->essayExamples()?->count() > 0,
                        'essayExampleIcon' => $item->essayExamples()?->first()?->thumbnail ? url('storage/'.$item->essayExamples()?->first()?->thumbnail) : null,
                        'hasInterviewPreparation'=>$item->interviewPreparations()?->count() > 0,
                        'interviewPreparationIcon' => $item->interviewPreparations()?->first()?->thumbnail ? url('storage/'.$item->interviewPreparations()?->first()?->thumbnail) : null,
                        'hasCriticalReading'=>$item->criticalReadings()?->count() > 0,
                        'criticalReadingIcon' => $item->criticalReadings()?->first()?->thumbnail ? url('storage/'.$item->criticalReadings()?->first()?->thumbnail) : null,
                        'subscriptionsCount'=> Order::where('subcategory_id', $item->id)->where('status','completed')->pluck('user_id')->unique()->count(),
                        'slug'=>$this->getTranslatedSlugs($item)
                    ];
            })
        ];
    }
    private function getTranslatedSlugs($item = null): array
    {
        if($item){
            $_this = $item;
        }else{
            $_this = $this;
        }
        $languages = Language::pluck('code')->toArray();

        $slugs = [];
        foreach ($languages as $lang) {
            $slugs[$lang] = $_this->translate($lang)->slug ?? null;
        }

        return $slugs;
    }
}
