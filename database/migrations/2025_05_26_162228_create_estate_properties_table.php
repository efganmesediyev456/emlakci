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
        Schema::create('estate_properties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("estate_id")->nullable();
            $table->foreign("estate_id")->references("id")->on("estates")->noActionOnDelete();
            $table->unsignedBigInteger( "property_id")->nullable();
            $table->foreign("property_id")->references("id")->on("properties")->noActionOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estate_properties');
    }
};
