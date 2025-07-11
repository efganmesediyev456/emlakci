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
        Schema::create('lang_translations', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->string('locale');
            $table->string('filename');
            $table->text('value')->nullable();
            $table->tinyInteger("status")->default(1);
            $table->integer("order")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lang_translations');
    }
};