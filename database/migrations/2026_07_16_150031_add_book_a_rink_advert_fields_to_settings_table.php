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
        Schema::table('settings', function (Blueprint $table) {
            $table->boolean('book_a_rink_advert_enabled')->default(true)->after('show_match_reports');
            $table->string('book_a_rink_price')->default('£5 per person per session')->after('book_a_rink_advert_enabled');
            $table->string('book_a_rink_phone')->default('07895 255006')->after('book_a_rink_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'book_a_rink_advert_enabled',
                'book_a_rink_price',
                'book_a_rink_phone',
            ]);
        });
    }
};
