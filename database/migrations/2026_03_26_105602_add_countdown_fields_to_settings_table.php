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
            $table->boolean('countdown_active')->default(false);
            $table->string('countdown_message')->nullable();
            $table->dateTime('countdown_target_date')->nullable();
            $table->foreignId('countdown_event_id')->nullable()->constrained('events')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropForeign(['countdown_event_id']);
            $table->dropColumn(['countdown_active', 'countdown_message', 'countdown_target_date', 'countdown_event_id']);
        });
    }
};
