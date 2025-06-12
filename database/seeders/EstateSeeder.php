<?php

namespace Database\Seeders;

use App\Models\Estate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class EstateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('estate_translations')->delete();
        DB::table('estate_media')->delete();
        DB::table('estate_properties')->delete();
        DB::table('estates')->delete();
        Estate::factory()->count(count: 100)->create();
    }
}
