<?php

namespace Database\Seeders;

use App\Models\OurOnMap;
use App\Models\WeOnTheMedia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class OurOnTheMapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('estate_translations')->delete();
        // DB::table('estate_media')->delete();
        // DB::table('estate_properties')->delete();
        // DB::table('estates')->delete();
        WeOnTheMedia::factory()->count(count: 100)->create();
    }
}
