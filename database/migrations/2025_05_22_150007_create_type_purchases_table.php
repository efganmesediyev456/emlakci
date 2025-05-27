<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_purchases', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('type_purchase_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_purchase_id');
            $table->string('locale')->index();
            $table->string('title');

            $table->unique(['type_purchase_id', 'locale']);
            $table->foreign('type_purchase_id')->references('id')->on('type_purchases')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('type_purchase_translations');
        Schema::dropIfExists('type_purchases');
    }
};