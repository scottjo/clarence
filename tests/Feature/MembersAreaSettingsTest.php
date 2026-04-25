<?php

namespace Tests\Feature;

use App\Livewire\MembersArea;
use App\Models\Setting;
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

        $settings = Setting::factory()->create([
            'members_area_heading' => $heading,
            'members_area_intro' => $intro,
            'members_password' => 'secret',
        ]);

        // Simulate middleware sharing
        config(['settings' => $settings]);
        view()->share('settings', $settings);

        Livewire::test(MembersArea::class)
            ->set('password', 'secret')
            ->call('login')
            ->assertSee($heading)
            ->assertSee($intro);
    }

    public function test_members_area_uses_default_heading_and_intro_when_not_set(): void
    {
        $settings = Setting::factory()->create([
            'members_area_heading' => null,
            'members_area_intro' => null,
            'members_password' => 'secret',
        ]);

        // Simulate middleware sharing
        config(['settings' => $settings]);
        view()->share('settings', $settings);

        Livewire::test(MembersArea::class)
            ->set('password', 'secret')
            ->call('login')
            ->assertSee('Members Area')
            ->assertSee('Welcome to the members-only section.');
    }
}
