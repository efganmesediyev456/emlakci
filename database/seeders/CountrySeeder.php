<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(!Country::where('removeable', 0)->where('foreign', 0)->exists()) {
            $country = Country::create([
                'removeable' => 0,
                'foreign' => 0
            ]);

            $locales = ['az', 'en', 'ru'];
            $titles = [
                'az' => 'Azərbaycan',
                'en' => 'Azerbaijan',  
                'ru' => 'Азербайджан' 
            ];

            foreach ($locales as $locale) {
                $country->translations()->create([
                    'locale' => $locale,
                    'title' => $titles[$locale]
                ]);
            }
        }
    }
}