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
        Schema::table('banner_details', function (Blueprint $table) {
            $table->dropColumn("icon");
        });

        Schema::table('banner_details', function (Blueprint $table) {
            $table->string("image1")->nullable();
            $table->string("image2")->nullable();
            $table->string("phone")->nullable();
            $table->string("first_payment")->nullable();
            $table->string("inner_credit")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banner_details', function (Blueprint $table) {
            //
        });
    }
};
