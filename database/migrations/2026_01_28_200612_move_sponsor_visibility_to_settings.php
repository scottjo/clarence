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
        Schema::table('sponsors', function (Blueprint $table) {
            $table->dropColumn(['show_on_all_pages', 'pages']);
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->boolean('sponsor_panel_show_on_all_pages')->default(true);
            $table->json('sponsor_panel_pages')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['sponsor_panel_show_on_all_pages', 'sponsor_panel_pages']);
        });

        Schema::table('sponsors', function (Blueprint $table) {
            $table->boolean('show_on_all_pages')->default(true);
            $table->json('pages')->nullable();
        });
    }
};
