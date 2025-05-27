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
        Schema::create('advantages', function (Blueprint $table) {
            $table->id();
            $table->string("icon")->nullable();
            $table->integer("order")->default(0);
            $table->tinyInteger("status")->default(1);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('advantage_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('advantage_id')->nullable();
            $table->foreign("advantage_id")
                ->references("id")
                ->on("advantages")
                ->nullOnDelete();
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->unique(['advantage_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advantage_translations');
        Schema::dropIfExists('advantages');
    }
};