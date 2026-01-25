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
            $table->string('footer_gradient_start')->nullable();
            $table->string('footer_gradient_end')->nullable();
            $table->string('footer_gradient_direction')->default('to right');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['footer_gradient_start', 'footer_gradient_end', 'footer_gradient_direction']);
        });
    }
};
