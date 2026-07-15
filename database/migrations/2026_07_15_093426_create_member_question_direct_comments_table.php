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
        Schema::create('member_question_direct_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_question_id');
            $table->foreignId('user_id');
            $table->text('body');
            $table->boolean('is_anonymous')->default(false);
            $table->string('display_name')->nullable();
            $table->timestamps();

            $table->foreign('member_question_id', 'mqdc_question_fk')
                ->references('id')
                ->on('member_questions')
                ->cascadeOnDelete();
            $table->foreign('user_id', 'mqdc_user_fk')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
            $table->index(['member_question_id', 'created_at'], 'mqdc_question_created_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_question_direct_comments');
    }
};
