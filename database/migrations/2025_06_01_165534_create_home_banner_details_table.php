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
        Schema::create('home_banner_details', function (Blueprint $table) {
            $table->id();
            $table->string("image1")->nullable();
            $table->string("image2")->nullable();
            $table->integer("first_payed")->default(0); 
            $table->integer("inside_credit")->default(0); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_banner_details');
    }
};
