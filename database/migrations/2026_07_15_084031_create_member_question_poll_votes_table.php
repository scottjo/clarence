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
        Schema::create('member_question_poll_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_question_id')->constrained()->cascadeOnDelete();
            $table->foreignId('member_question_poll_option_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['member_question_id', 'user_id']);
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
