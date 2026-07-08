<?php

namespace Tests\Feature;

use App\Livewire\MembersArea;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class MembersAreaSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_members_area_uses_custom_heading_and_intro_from_settings(): void
    {
        $heading = 'Custom Heading';
        $intro = 'Custom Intro Text';
        $user = User::factory()->create([
            'name' => 'Jane Member',
        ]);

        $settings = Setting::factory()->create([
            'members_area_heading' => $heading,
            'members_area_intro' => $intro,
        ]);

        // Simulate middleware sharing
        config(['settings' => $settings]);
        view()->share('settings', $settings);

        Livewire::actingAs($user)
            ->test(MembersArea::class)
            ->assertSee('Welcome Jane Member to the members only section.')
            ->assertSee($heading)
            ->assertSee($intro);
    }

    public function test_members_area_uses_default_heading_when_not_set(): void
    {
        $settings = Setting::factory()->create([
            'members_area_heading' => null,
            'members_area_intro' => null,
        ]);

        // Simulate middleware sharing
        config(['settings' => $settings]);
        view()->share('settings', $settings);

        Livewire::actingAs(User::factory()->create())
            ->test(MembersArea::class)
            ->assertSee('Members Area');
    }
}
