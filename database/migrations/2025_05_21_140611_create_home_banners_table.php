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
        Schema::create('home_banners', function (Blueprint $table) {
            $table->id();
            $table->string("image")->nullable();
            $table->integer("order")->default(0);
            $table->string("url")->nullable();
            $table->tinyInteger("status")->default(1);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('home_banner_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('home_banner_id')->nullable();
            $table->foreign("home_banner_id")
                ->references("id")
                ->on("home_banners")
                ->nullOnDelete();
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->unique(['home_banner_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_banners');
    }
};
