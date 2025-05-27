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
        // Schema::table('about_translations', function (Blueprint $table) {
        //     $table->dropColumn("biography_title");
        //     $table->dropColumn("name");
        //     $table->dropColumn("position");
        //     $table->dropColumn("biography_content");
        // });

        // Schema::table('abouts', function (Blueprint $table) {
        //     $table->dropColumn("published_books_count");
        //     $table->dropColumn("certificates_count");
        //     $table->dropColumn("years_in_profession");
        //     $table->dropColumn("pdf");
        //     $table->integer("foreign_advertisements_count")->nullable();
        //     $table->integer("local_advertisements_count")->nullable();
        //     $table->integer("yearly_activity")->nullable();
        // });

        // Schema::table('abouts', function (Blueprint $table) {
        //     $table->string("image2")->nullable();
        //     $table->string("image3")->nullable();
        // });

        // Schema::table('about_translations', function (Blueprint $table) {
        //     $table->string("choose_why_title")->nullable();
        //     $table->text("choose_why_desc")->nullable();
        // });

        // Schema::table('about_translations', function (Blueprint $table) {
        //     $table->string("indicator_title1")->nullable();
        //     $table->string("indicator_title2")->nullable();
        //     $table->text("indicator_description")->nullable();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
