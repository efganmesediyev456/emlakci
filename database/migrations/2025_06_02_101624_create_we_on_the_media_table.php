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
        Schema::create('we_on_the_media', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->date('date');
            $table->string('youtube_link')->nullable();
            $table->boolean('status')->default(true);
            $table->integer('order')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('we_on_the_media_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('we_on_the_media_id')->constrained()->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->unique(['we_on_the_media_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('we_on_the_media_translations');
        Schema::dropIfExists('we_on_the_media');
    }
};