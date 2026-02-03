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
        Schema::table('settings', function (Blueprint $table) {
            $table->string('winner_col_bg')->nullable();
            $table->string('winner_col_bg_dark')->nullable();
            $table->string('winner_comp_text_color')->nullable();
            $table->string('winner_comp_text_color_dark')->nullable();
            $table->string('winner_name_text_color')->nullable();
            $table->string('winner_name_text_color_dark')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'winner_col_bg',
                'winner_col_bg_dark',
                'winner_comp_text_color',
                'winner_comp_text_color_dark',
                'winner_name_text_color',
                'winner_name_text_color_dark',
            ]);
        });
    }
};
