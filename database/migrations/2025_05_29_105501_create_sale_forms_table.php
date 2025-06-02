<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sale_forms', function (Blueprint $table) {
            $table->id();
            $table->string("name")->nullable();
            $table->string("phone")->nullable();
            $table->unsignedBigInteger("country_id")->nullable();
            $table->foreign("country_id")->references("id")->on("countries")->nullOnDelete();
            $table->string("email")->nullable();
            $table->unsignedBigInteger("city_id")->nullable();
            $table->foreign("city_id")->references("id")->on("cities")->nullOnDelete();
            $table->unsignedBigInteger("type_estate_id")->nullable();
            $table->foreign("type_estate_id")->references("id")->on("type_estates")->nullOnDelete();
            $table->integer("rooms")->nullable();
            $table->integer("floors")->nullable();
            $table->integer("min_area")->nullable();
            $table->integer("max_area")->nullable();
            $table->double("price", 10, 2)->nullable();
            $table->longText("text")->nullable();
            $table->timestamps();
        });

        Schema::create('sale_form_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("sale_form_id")->nullable();
            $table->foreign("sale_form_id")->references("id")->on("sale_forms")->nullOnDelete();
            $table->longText("file_path")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_forms');
    }
};
