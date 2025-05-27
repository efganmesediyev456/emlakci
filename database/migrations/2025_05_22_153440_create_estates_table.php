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
        Schema::create('estates', function (Blueprint $table) {
            $table->id();
            $table->decimal('price', 15, 2)->nullable();
            $table->decimal('area', 10, 2)->nullable();
            $table->integer('rooms')->nullable();
            // $table->integer('bathrooms')->nullable();
            $table->integer('floor')->nullable();
            $table->integer('total_floors')->nullable();
            $table->string('type')->nullable(); 
            $table->string('status_type')->nullable(); 
            $table->string('image')->nullable();
            // $table->year('construction_year')->nullable();
            $table->boolean('mortgage')->default(false);
            $table->boolean('has_extract')->default(false);
            // $table->boolean('elevator')->default(false);
            // $table->boolean('balcony')->default(false);
            // $table->boolean('garden')->default(false);
            // $table->boolean('furnished')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('estate_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estate_id')->nullable();
            $table->foreign("estate_id")->references("id")->on("estates")->nullOnDelete();
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->string('seo_keywords')->nullable();
            $table->string('seo_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('address')->nullable();
            $table->string('location')->nullable();
            $table->string('slug')->nullable();
            $table->unique(['estate_id', 'locale']);
        });


         Schema::create('estate_media', function (Blueprint $table) {
            $table->id();
            $table->string("file")->nullable();
            $table->tinyInteger("status")->default(0);
            $table->integer("order")->default(0);
            $table->unsignedBigInteger("estate_id")->nullable();
            $table->foreign("estate_id")->references("id")->on("estates")->noActionOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estate_media');
        Schema::dropIfExists('estate_translations');
        Schema::dropIfExists('estates');
        
    }
};
