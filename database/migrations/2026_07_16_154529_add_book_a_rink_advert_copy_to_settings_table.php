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
            $table->string('book_a_rink_title')->nullable()->after('book_a_rink_advert_enabled');
            $table->text('book_a_rink_description')->nullable()->after('book_a_rink_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'book_a_rink_title',
                'book_a_rink_description',
            ]);
        });
    }
};
