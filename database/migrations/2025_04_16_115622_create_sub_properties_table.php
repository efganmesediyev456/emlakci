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
        Schema::create('sub_properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->noActionOnDelete();
            $table->boolean("status")->default(true);
            $table->integer("order")->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_properties');
    }
};
