<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
          
          Schema::table('our_on_maps', function (Blueprint $table) {
                $table->dropColumn("map");
            });

         Schema::create('our_on_map_translations', function (Blueprint $table) {
             $table->id();
            $table->unsignedBigInteger('our_on_map_id')->nullable();
            $table->foreign("our_on_map_id")
                ->references("id")
                ->on("our_on_maps")
                ->nullOnDelete();
            $table->string('locale')->index();
            $table->string('contact_title1')->nullable();
            $table->text('contact_content1')->nullable();
            $table->string('contact_title2')->nullable();
            $table->text('contact_content2')->nullable();
            $table->unique(['our_on_map_id', 'locale']);
        });



          Schema::table('our_on_map_translations', function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->string('seo_keywords')->nullable();
            $table->string('seo_description')->nullable();
        });

        Schema::table('our_on_map_translations', function (Blueprint $table) {
            $table->string('address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
