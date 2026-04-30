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
        Schema::create('match_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fixture_id')->nullable()->constrained()->nullOnDelete();
            $table->string('team');
            $table->string('opponent');
            $table->year('year');
            $table->string('title');
            $table->integer('our_score');
            $table->integer('opponent_score');
            $table->string('author');
            $table->longText('description');
            $table->text('rink_scores')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_reports');
    }
};
