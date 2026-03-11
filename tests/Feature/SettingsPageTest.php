<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Filament\Pages\Settings;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SettingsPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_settings_page_is_accessible_to_admin(): void
    {
        $user = User::factory()->create([
            'roles' => [UserRole::Administrator->value],
        ]);

        $response = $this->actingAs($user)->get('/admin/settings');

        $response->assertStatus(200);
    }

    public function test_settings_page_can_save_without_media(): void
    {
        $user = User::factory()->create([
            'roles' => [UserRole::Administrator->value],
        ]);

        $this->actingAs($user);

        Livewire::test(Settings::class)
            ->fillForm([
                'club_name' => 'Updated Club Name',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas(Setting::class, [
            'club_name' => 'Updated Club Name',
        ]);
    }

    public function test_livewire_update_route_works_with_load_settings_middleware(): void
    {
        // Livewire internal requests usually go to /livewire/update or /livewire-hash/update
        // We want to make sure our middleware doesn't crash it
        $response = $this->post('/livewire-abc123/update', [
            'components' => [],
        ], [
            'X-Livewire' => true,
            'X-CSRF-TOKEN' => csrf_token(),
        ]);

        // It might be 404 if the components are empty or invalid,
        // but it shouldn't be 419 (CSRF) if we handle it right,
        // though in testing environment CSRF is often disabled.
        // The main goal is to ensure it doesn't throw a 500 because of Route::match()
        $this->assertNotEquals(500, $response->getStatusCode());
    }

    public function test_load_settings_middleware_skips_hashed_livewire_matching(): void
    {
        // This is a bit hard to test directly without mocking the Route facade,
        // but we can verify that the middleware doesn't crash on a livewire path.
        $response = $this->get('/livewire-abc123/update');
        // We expect NOT 500. 404 or 405 is fine for GET on update route,
        // as long as it doesn't trigger the match error.
        $this->assertNotEquals(500, $response->getStatusCode());
    }
}
