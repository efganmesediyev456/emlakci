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
        Schema::create('event_banners', function (Blueprint $table) {
            $table->id();
            $table->string("image")->nullable();
            $table->string("url")->nullable();
            $table->timestamps();
        });

        Schema::create('event_banner_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_banner_id')->nullable();
            $table->foreign("event_banner_id")->references("id")->on("event_banners")->nullOnDelete();
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->unique(['event_banner_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_banner_translations');
        Schema::dropIfExists('event_banners');
    }
};