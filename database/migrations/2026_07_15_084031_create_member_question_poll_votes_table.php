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
        Schema::dropIfExists('member_question_poll_votes');

        Schema::create('member_question_poll_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_question_id');
            $table->foreignId('member_question_poll_option_id');
            $table->foreignId('user_id');
            $table->timestamps();

            $table->foreign('member_question_id', 'mqpv_question_fk')
                ->references('id')
                ->on('member_questions')
                ->cascadeOnDelete();
            $table->foreign('member_question_poll_option_id', 'mqpv_option_fk')
                ->references('id')
                ->on('member_question_poll_options')
                ->cascadeOnDelete();
            $table->foreign('user_id', 'mqpv_user_fk')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
            $table->unique(['member_question_id', 'user_id'], 'mqpv_question_user_unique');
            $table->index(['member_question_poll_option_id', 'created_at'], 'poll_option_votes_created_at_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_question_poll_votes');
    }
};
