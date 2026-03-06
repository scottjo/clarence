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
        Schema::table('facilities', function (Blueprint $table) {
            $table->dropColumn('image');
        });

        Schema::table('officers', function (Blueprint $table) {
            $table->dropColumn('avatar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facilities', function (Blueprint $table) {
            $table->string('image')->nullable();
        });

        Schema::table('officers', function (Blueprint $table) {
            $table->string('avatar')->nullable();
        });
    }
};
