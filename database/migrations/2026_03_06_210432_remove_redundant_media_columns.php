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
        Schema::table('news_articles', function (Blueprint $table) {
            $table->dropColumn(['image', 'attachments']);
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('image');
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['header_logo', 'footer_logo_left', 'footer_logo_right', 'membership_application_form']);
        });

        Schema::table('heroes', function (Blueprint $table) {
            $table->dropColumn('image');
        });

        Schema::table('intro_blocks', function (Blueprint $table) {
            $table->dropColumn(['left_image', 'right_image']);
        });

        Schema::table('sponsors', function (Blueprint $table) {
            $table->dropColumn('logo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news_articles', function (Blueprint $table) {
            $table->string('image')->nullable();
            $table->text('attachments')->nullable();
        });

        Schema::table('events', function (Blueprint $table) {
            $table->string('image')->nullable();
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->string('header_logo')->nullable();
            $table->string('footer_logo_left')->nullable();
            $table->string('footer_logo_right')->nullable();
            $table->string('membership_application_form')->nullable();
        });

        Schema::table('heroes', function (Blueprint $table) {
            $table->string('image')->nullable();
        });

        Schema::table('intro_blocks', function (Blueprint $table) {
            $table->string('left_image')->nullable();
            $table->string('right_image')->nullable();
        });

        Schema::table('sponsors', function (Blueprint $table) {
            $table->string('logo')->nullable();
        });
    }
};
