<?php

namespace Database\Factories;

use App\Models\BlogNew;
use App\Models\Country;
use App\Models\Estate;
use App\Models\EstateMedia;
use App\Models\EstateProperty;
use App\Models\Language;
use App\Models\BlogNewMedia;
use App\Models\Property;
use App\Models\TypeEstate;
use App\Models\TypePurchase;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class EstateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Estate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $imageUrl = "https://picsum.photos/800/600";
        $imageContents = Http::get($imageUrl)->body();
        $filename = 'blognews_' . uniqid() . '.jpg';
        Storage::disk('public')->put('uploads/estates/' . $filename, $imageContents);
        $type_estate  = TypeEstate::inRandomOrder()->first();
        $country   = Country::inRandomOrder()->first();
        $city = $country->cities()->inRandomOrder()->first();
        $type_purchase = TypePurchase::inRandomOrder()->first();

        return [
            'image' => 'uploads/estates/' . $filename,
            'price' => $this->faker->numberBetween(0, 10000), 
            'area' => $this->faker->numberBetween(0, 10000), 
            'rooms' => $this->faker->numberBetween(0, 20), 
            'floor' => $this->faker->numberBetween(0, 10), 
            'total_floors' => $this->faker->numberBetween(0, 10), 
            'mortgage' => $this->faker->numberBetween(0, 1), 
            'is_vip' => $this->faker->numberBetween(0, 1), 
            'has_extract' => $this->faker->numberBetween(0, 1), 
            'type_estate_id'=>$type_estate->id,
            'country_id'=>$country->id,
            'city_id'=>$city?->id,
            'is_new'=>$this->faker->numberBetween(0, 1), 
            'call_number'=>$this->faker->numberBetween(10000000, int2: 90000000), 
            'whatsapp_number'=>$this->faker->numberBetween(10000000, int2: 90000000), 
            'type_purchase_id'=>$type_purchase->id,
            'map'=>"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12156.609233436639!2d49.861909999999995!3d40.38331685!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40307caca81c4cb1%3A0x8d9c4bfe08e61631!2sThe%20Ritz-Carlton%2C%20Baku!5e0!3m2!1sen!2saz!4v1748848881803!5m2!1sen!2saz",
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Estate $blogNew) {
            // Create translations for the blog news
            $languages = Language::all();
            foreach ($languages as $language) {
                $title = $this->faker->words(3, true);
                $subtitle = $this->faker->words(3, true);
                $slug = Str::slug($title);


                $keywords = $this->faker->words(5);
                $seoKeywords = array_map(function($word) {
                    return ['value' => $word];
                }, $keywords);
                // Create translations in a single record
                $blogNew->translations()->create([
                    'locale' => $language->code,
                    'title' => $title,
                    'slug' => $slug,
                    'subtitle' => $subtitle,
                    'description'=> $this->faker->paragraphs(3, true),
                    'seo_keywords'=> json_encode($seoKeywords),
                    'seo_description'=> $this->faker->sentence(10),
                    'address'=> $this->faker->sentence(4),
                    'location'=> $this->faker->sentence(nbWords: 3),
                    'district'=> $this->faker->sentence(nbWords: 6),
                ]);
            }

            // Create 3-5 media files for each blog
            $mediaCount = rand(3, 5);
            for ($i = 0; $i < $mediaCount; $i++) {
                $mediaUrl = "https://picsum.photos/800/400";
                $mediaContents = Http::get($mediaUrl)->body();
                $mediaFilename = 'media_' . uniqid() . '.jpg';
                Storage::disk('public')->put('uploads/estates/media/' . $mediaFilename, $mediaContents);

                EstateMedia::create([
                    'file' => 'uploads/estates/media/' . $mediaFilename,
                    'status' => 1,
                    'order' => $i,
                    'estate_id' => $blogNew->id
                ]);
                $property = Property::inRandomOrder()->first();

                if(!EstateProperty::where('estate_id', $blogNew->id)->where('property_id',$property->id)->exists()){
                      EstateProperty::create([
                        'estate_id'=>$blogNew->id,
                        'property_id'=>$property->id
                    ]);
                }
              
            }

        });
    }
}