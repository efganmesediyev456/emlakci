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
use App\Models\WeOnTheMedia;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class OurOnTheMapFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WeOnTheMedia::class;

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


        $youtubeIds = [
            'dQw4w9WgXcQ', // Rick Astley
            'kXYiU_JCYtU', // Linkin Park - Numb
            'hT_nvWreIhg', // OneRepublic - Counting Stars
            'CevxZvSJLk8', // Imagine Dragons - Thunder
            '9bZkp7q19f0', // PSY - Gangnam Style
            '60ItHLz5WEA', // Alan Walker - Faded
        ];

        return [
            'image' => 'uploads/estates/' . $filename,
            'date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'youtube_link' => 'https://www.youtube.com/watch?v=' . $this->faker->randomElement($youtubeIds),
          ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (WeOnTheMedia $blogNew) {
            // Create translations for the blog news
            $languages = Language::all();
            foreach ($languages as $language) {
                $title = $this->faker->words(3, true);
                $subtitle = $this->faker->words(3, true);            
                $blogNew->translations()->create([
                    'locale' => $language->code,
                    'title' => $title,
                    'subtitle' => $subtitle,
                ]);
            }
        });
    }
}