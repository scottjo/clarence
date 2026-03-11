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
        // Indexes for news_articles table
        Schema::table('news_articles', function (Blueprint $table) {
            $table->index(['is_active', 'published_at'], 'news_active_published_idx');
        });

        // Indexes for events table
        Schema::table('events', function (Blueprint $table) {
            $table->index(['is_active', 'start_time'], 'events_active_start_idx');
        });

        // Indexes for fixtures table
        Schema::table('fixtures', function (Blueprint $table) {
            $table->index(['type', 'date'], 'fixtures_type_date_idx');
        });

        // Indexes for officers table
        Schema::table('officers', function (Blueprint $table) {
            $table->index(['is_active', 'sort_order'], 'officers_active_sort_idx');
        });

        // Indexes for social_media_links table
        Schema::table('social_media_links', function (Blueprint $table) {
            $table->index(['is_active', 'sort_order'], 'social_media_active_sort_idx');
        });

        // Indexes for useful_contacts table
        Schema::table('useful_contacts', function (Blueprint $table) {
            $table->index(['is_active', 'sort_order'], 'useful_contacts_active_sort_idx');
        });

        // Indexes for pinned_items table
        Schema::table('pinned_items', function (Blueprint $table) {
            $table->index('is_active', 'pinned_items_active_idx');
        });

        // Indexes for competition_results table
        Schema::table('competition_results', function (Blueprint $table) {
            $table->index(['year', 'competition_id', 'category'], 'competition_results_lookup_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news_articles', function (Blueprint $table) {
            $table->dropIndex('news_active_published_idx');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropIndex('events_active_start_idx');
        });

        Schema::table('fixtures', function (Blueprint $table) {
            $table->dropIndex('fixtures_type_date_idx');
        });

        Schema::table('officers', function (Blueprint $table) {
            $table->dropIndex('officers_active_sort_idx');
        });

        Schema::table('social_media_links', function (Blueprint $table) {
            $table->dropIndex('social_media_active_sort_idx');
        });

        Schema::table('useful_contacts', function (Blueprint $table) {
            $table->dropIndex('useful_contacts_active_sort_idx');
        });

        Schema::table('pinned_items', function (Blueprint $table) {
            $table->dropIndex('pinned_items_active_idx');
        });

        Schema::table('competition_results', function (Blueprint $table) {
            $table->dropIndex('competition_results_lookup_idx');
        });
    }
};
