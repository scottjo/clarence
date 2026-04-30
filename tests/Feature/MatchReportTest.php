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
}
