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
        Schema::create('property_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id')->nullable();
            $table->foreign("property_id")->references("id")->on("properties")->nullOnDelete();
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->unique(['property_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_translations');
    }
};
