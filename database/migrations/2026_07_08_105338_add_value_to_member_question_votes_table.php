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
        if (Schema::hasColumn('member_question_votes', 'value')) {
            return;
        }

        Schema::table('member_question_votes', function (Blueprint $table) {
            $table->smallInteger('value')->default(1)->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasColumn('member_question_votes', 'value')) {
            return;
        }

        Schema::table('member_question_votes', function (Blueprint $table) {
            $table->dropColumn('value');
        });
    }
};
