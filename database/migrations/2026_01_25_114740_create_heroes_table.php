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
        Schema::create('heroes', function (Blueprint $table) {
            $table->id();
            $table->string('page_identifier')->unique(); // Route name or URL path
            $table->string('image')->nullable();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('intro_text')->nullable();

            // Title styles
            $table->string('title_color')->default('#ffffff');
            $table->string('title_size')->default('text-5xl md:text-7xl');

            // Subtitle styles
            $table->string('subtitle_color')->default('#ffffff');
            $table->string('subtitle_size')->default('text-xl md:text-2xl');

            // Intro text styles
            $table->string('intro_color')->default('#ffffff');
            $table->string('intro_size')->default('text-lg');

            // Font and general
            $table->string('font_family')->default('font-sans');
            $table->integer('overlay_opacity')->default(50);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('heroes');
    }
};
