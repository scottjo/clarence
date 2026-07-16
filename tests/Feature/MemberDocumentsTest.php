<?php

namespace Tests\Feature;

use App\Livewire\MembersArea;
use App\Models\Newsletter;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class MemberDocumentsTest extends TestCase
{
    use RefreshDatabase;

    public function test_members_area_splits_newsletters_and_committee_minutes_by_type(): void
    {
        $settings = Setting::factory()->create();

        Newsletter::factory()->create([
            'title' => 'April Newsletter',
            'type' => Newsletter::TYPE_NEWSLETTER,
            'issue_date' => '2026-04-01',
        ]);

        Newsletter::factory()->create([
            'title' => 'Committee Minutes April',
            'type' => Newsletter::TYPE_MINUTES,
            'issue_date' => '2026-04-15',
        ]);

        Newsletter::factory()->create([
            'title' => 'Private Background Paper',
            'type' => Newsletter::TYPE_OTHER,
            'issue_date' => '2026-04-20',
        ]);

        Newsletter::factory()->create([
            'title' => 'Inactive Minutes',
            'type' => Newsletter::TYPE_MINUTES,
            'is_active' => false,
            'issue_date' => '2026-04-21',
        ]);

        config(['settings' => $settings]);
        view()->share('settings', $settings);

        Livewire::actingAs(User::factory()->create())
            ->test(MembersArea::class)
            ->assertSee('Newsletters')
            ->assertSee('April Newsletter')
            ->assertSee('Committee Minutes')
            ->assertSee('Committee Minutes April')
            ->assertDontSee('Private Background Paper')
            ->assertDontSee('Inactive Minutes');
    }
}
