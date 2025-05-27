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
        Schema::table('estates', function (Blueprint $table) {
            $table->dropColumn("type");
            $table->unsignedBigInteger("type_estate_id")->nullable();
            $table->foreign("type_estate_id")->references("id")->on("type_estates")->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estates', function (Blueprint $table) {
            //
        });
    }
};
