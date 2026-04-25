<?php

namespace Tests\Feature;

use App\Livewire\MembersArea;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class MemberLoginPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_member_can_login_with_correct_password(): void
    {
        // Setup setting with a password
        $password = 'secret123';
        Setting::factory()->create([
            'members_password' => $password,
        ]);

        // Simulated config as set by middleware
        $settings = Setting::first();
        config(['settings' => $settings]);
        view()->share('settings', $settings);

        Livewire::test(MembersArea::class)
            ->set('password', $password)
            ->call('login')
            ->assertHasNoErrors()
            ->assertSet('isAuthenticated', true);
    }

    public function test_member_can_login_with_correct_password_when_config_is_null(): void
    {
        // Setup setting with a password
        $password = 'secret123';
        Setting::factory()->create([
            'members_password' => $password,
        ]);

        // Clear config to simulate a fresh state
        config(['settings' => null]);
        view()->share('settings', null);

        Livewire::test(MembersArea::class)
            ->set('password', $password)
            ->call('login')
            ->assertHasNoErrors()
            ->assertSet('isAuthenticated', true);
    }

    public function test_member_cannot_login_with_incorrect_password(): void
    {
        Setting::factory()->create([
            'members_password' => 'secret123',
        ]);

        $settings = Setting::first();
        config(['settings' => $settings]);
        view()->share('settings', $settings);

        Livewire::test(MembersArea::class)
            ->set('password', 'wrong-password')
            ->call('login')
            ->assertHasErrors(['password'])
            ->assertSet('isAuthenticated', false);
    }
}
