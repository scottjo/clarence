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
        Schema::dropIfExists('member_question_poll_options');

        Schema::create('member_question_poll_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_question_id');
            $table->string('label');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->foreign('member_question_id', 'mqpo_question_fk')
                ->references('id')
                ->on('member_questions')
                ->cascadeOnDelete();
            $table->index(['member_question_id', 'sort_order'], 'mqpo_question_sort_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_question_poll_options');
    }
};
