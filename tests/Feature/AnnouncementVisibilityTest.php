<?php

namespace Tests\Feature;

use App\Livewire\MembersArea;
use App\Models\Announcement;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AnnouncementVisibilityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Ensure settings are available for views
        $settings = Setting::factory()->create();
        config(['settings' => $settings]);
        view()->share('settings', $settings);
    }

    /**
     * A basic feature test example.
     */
    public function test_public_announcement_is_visible_on_home_page(): void
    {
        Announcement::factory()->create([
            'header' => 'Public Announcement',
            'is_active' => true,
            'show_on_public' => true,
            'is_members_only' => false,
        ]);

        $this->get(route('home'))
            ->assertStatus(200)
            ->assertSee('Public Announcement');
    }

    public function test_members_only_announcement_is_not_visible_on_home_page(): void
    {
        Announcement::factory()->create([
            'header' => 'Secret Announcement',
            'is_active' => true,
            'show_on_public' => false,
            'is_members_only' => true,
        ]);

        $this->get(route('home'))
            ->assertStatus(200)
            ->assertDontSee('Secret Announcement');
    }

    public function test_members_only_announcement_is_visible_in_members_area(): void
    {
        Announcement::factory()->create([
            'header' => 'Secret Announcement',
            'is_active' => true,
            'show_on_public' => false,
            'is_members_only' => true,
        ]);

        Livewire::actingAs(User::factory()->create())
            ->test(MembersArea::class)
            ->assertSee('Secret Announcement');
    }

    public function test_public_announcement_without_members_flag_is_not_visible_in_members_area(): void
    {
        Announcement::factory()->create([
            'header' => 'Public Only Announcement',
            'is_active' => true,
            'show_on_public' => true,
            'is_members_only' => false,
        ]);

        Livewire::actingAs(User::factory()->create())
            ->test(MembersArea::class)
            ->assertDontSee('Public Only Announcement');
    }

    public function test_announcement_can_be_both_public_and_members_only(): void
    {
        Announcement::factory()->create([
            'header' => 'Global Announcement',
            'is_active' => true,
            'show_on_public' => true,
            'is_members_only' => true,
        ]);

        $this->get(route('home'))
            ->assertSee('Global Announcement');

        Livewire::actingAs(User::factory()->create())
            ->test(MembersArea::class)
            ->assertSee('Global Announcement');
    }
}
