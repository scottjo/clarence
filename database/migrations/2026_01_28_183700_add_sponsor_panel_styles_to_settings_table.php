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
            $table->string('sponsor_panel_bg_color')->nullable();
            $table->string('sponsor_panel_pinstripe_color')->nullable();
            $table->string('sponsor_panel_pinstripe_width')->default('medium');
            $table->string('sponsor_panel_pinstripe_style')->default('single');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'sponsor_panel_bg_color',
                'sponsor_panel_pinstripe_color',
                'sponsor_panel_pinstripe_width',
                'sponsor_panel_pinstripe_style',
            ]);
        });
    }
};
