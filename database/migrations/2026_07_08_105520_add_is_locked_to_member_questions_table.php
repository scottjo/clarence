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
        if (Schema::hasColumn('member_questions', 'is_locked')) {
            return;
        }

        Schema::table('member_questions', function (Blueprint $table) {
            $table->boolean('is_locked')->default(false)->after('is_anonymous');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasColumn('member_questions', 'is_locked')) {
            return;
        }

        Schema::table('member_questions', function (Blueprint $table) {
            $table->dropColumn('is_locked');
        });
    }
};
