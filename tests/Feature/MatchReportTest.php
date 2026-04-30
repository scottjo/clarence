<?php

namespace Tests\Feature;

use App\Models\MatchReport;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MatchReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_match_reports_page_is_accessible_when_enabled(): void
    {
        Setting::factory()->create(['show_match_reports' => true]);

        $response = $this->get(route('match-reports.index'));

        $response->assertStatus(200);
    }

    public function test_match_reports_page_is_hidden_when_disabled(): void
    {
        Setting::factory()->create(['show_match_reports' => false]);

        $response = $this->get(route('match-reports.index'));

        $response->assertStatus(404);
    }

    public function test_can_view_single_match_report(): void
    {
        Setting::factory()->create(['show_match_reports' => true]);
        $report = MatchReport::factory()->create(['is_published' => true]);

        $response = $this->get(route('match-reports.show', $report));

        $response->assertStatus(200);
        $response->assertSee($report->title);
    }

    public function test_cannot_view_unpublished_match_report(): void
    {
        Setting::factory()->create(['show_match_reports' => true]);
        $report = MatchReport::factory()->create(['is_published' => false]);

        $response = $this->get(route('match-reports.show', $report));

        $response->assertStatus(404);
    }

    public function test_match_reports_are_visible_on_home_page_when_enabled(): void
    {
        Setting::factory()->create(['show_match_reports' => true]);
        $report = MatchReport::factory()->create(['is_published' => true]);

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('Latest Match Reports');
        $response->assertSee($report->title);
    }

    public function test_match_reports_are_not_visible_on_home_page_when_disabled(): void
    {
        Setting::factory()->create(['show_match_reports' => false]);
        $report = MatchReport::factory()->create(['is_published' => true]);

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertDontSee('Latest Match Reports');
        $response->assertDontSee($report->title);
    }

    public function test_only_unread_match_reports_are_visible_on_home_page(): void
    {
        Setting::factory()->create(['show_match_reports' => true]);
        $readReport = MatchReport::factory()->create(['is_published' => true, 'title' => 'Read Report']);
        $unreadReport = MatchReport::factory()->create(['is_published' => true, 'title' => 'Unread Report']);

        $response = $this->withSession(['viewed_match_reports' => [$readReport->id]])
            ->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('Unread Report');
        $response->assertDontSee('Read Report');
    }

    public function test_home_page_shows_at_most_three_unread_match_reports(): void
    {
        Setting::factory()->create(['show_match_reports' => true]);

        MatchReport::query()->delete();
        MatchReport::factory()->create(['is_published' => true, 'title' => 'Report 1', 'created_at' => now()->subDays(4)]);
        MatchReport::factory()->create(['is_published' => true, 'title' => 'Report 2', 'created_at' => now()->subDays(3)]);
        MatchReport::factory()->create(['is_published' => true, 'title' => 'Report 3', 'created_at' => now()->subDays(2)]);
        MatchReport::factory()->create(['is_published' => true, 'title' => 'Report 4', 'created_at' => now()->subDays(1)]);

        $response = $this->get(route('home'));
        $response->assertSee('Report 4');
        $response->assertSee('Report 3');
        $response->assertSee('Report 2');
        $response->assertDontSee('Report 1');
    }
}
