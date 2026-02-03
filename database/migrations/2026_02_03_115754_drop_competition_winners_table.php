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
        Schema::dropIfExists('competition_winners');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('competition_winners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('competition_id')->constrained()->cascadeOnDelete();
            $table->integer('year');
            $table->string('category')->nullable();
            $table->json('names')->nullable();
            $table->boolean('no_competition')->default(false);
            $table->timestamps();
        });
    }
};
