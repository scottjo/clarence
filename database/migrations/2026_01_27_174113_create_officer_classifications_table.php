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
        Schema::create('officer_classifications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('bg_color')->default('#ffffff');
            $table->string('text_color')->default('#000000');
            $table->string('bg_color_dark')->default('#1f2937');
            $table->string('text_color_dark')->default('#ffffff');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('officer_classifications');
    }
};
