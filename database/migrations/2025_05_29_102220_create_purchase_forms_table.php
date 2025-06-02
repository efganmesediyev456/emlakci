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
        Schema::create('purchase_forms', function (Blueprint $table) {
            $table->id();
            $table->string("name")->nullable();
            $table->string("phone")->nullable();
            $table->string("email")->nullable();
            $table->unsignedBigInteger("type_estate_id")->nullable();
            $table->foreign("type_estate_id")->references("id")->on("type_estates")->nullOnDelete();
            $table->unsignedBigInteger("type_purchase_id")->nullable();
            $table->foreign("type_purchase_id")->references("id")->on("type_purchases")->nullOnDelete();
            $table->unsignedBigInteger("country_id")->nullable();
            $table->foreign("country_id")->references("id")->on("countries")->nullOnDelete();
            $table->unsignedBigInteger("city_id")->nullable();
            $table->foreign("city_id")->references("id")->on("cities")->nullOnDelete();
            $table->integer("rooms")->nullable();
            $table->integer("floors")->nullable();
            $table->double("price",  10, 2)->nullable();
            $table->integer("min_area")->nullable();
            $table->integer("max_area")->nullable();
            $table->longText("text")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_forms');
    }
};
