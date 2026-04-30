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
        Schema::table('match_reports', function (Blueprint $table) {
            $table->dropConstrainedForeignId('fixture_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('match_reports', function (Blueprint $table) {
            $table->foreignId('fixture_id')->nullable()->constrained()->nullOnDelete();
        });
    }
};
