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
          Schema::table('site_settings', function (Blueprint $table) {
            $columns = [
                "service_whatsapp_number", "whatsapp_textbook_number", 
                "header_site_url1", "header_site_icon1", 
                "header_site_icon2", "header_site_url2",
                "header_site_icon3", "header_site_url3",
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('site_settings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
