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
            $table->string('pinstripe_color')->nullable()->after('footer_gradient_direction');
            $table->string('pinstripe_width')->nullable()->default('medium')->after('pinstripe_color');
            $table->string('pinstripe_style')->nullable()->default('thin')->after('pinstripe_width');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['pinstripe_color', 'pinstripe_width', 'pinstripe_style']);
        });
    }
};
