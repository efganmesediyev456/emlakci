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
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('faq_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('faq_id');
            $table->string('locale')->index();
            $table->string('title');
            $table->text('description')->nullable();

            $table->unique(['faq_id', 'locale']);
            $table->foreign('faq_id')->references('id')->on('faqs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faq_translations');
        Schema::dropIfExists('faqs');
    }
};