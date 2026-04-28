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
        Schema::table('leagues', function (Blueprint $table) {
            $table->dropColumn('season');
        });

        Schema::table('league_standings', function (Blueprint $table) {
            $table->string('season')->after('league_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('league_standings', function (Blueprint $table) {
            $table->dropColumn('season');
        });

        Schema::table('leagues', function (Blueprint $table) {
            $table->string('season')->nullable();
        });
    }
};
