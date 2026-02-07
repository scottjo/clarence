<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Health\Commands\RunHealthChecksCommand;
use Tests\TestCase;

class HealthCheckTest extends TestCase
{
    use RefreshDatabase;

    public function test_health_check_command_runs_successfully(): void
    {
        $this->artisan(RunHealthChecksCommand::class)
            ->assertExitCode(0);

        // Check for any result in the database
        $this->assertDatabaseCount('health_check_result_history_items', 12);
    }

    public function test_health_page_is_accessible_to_admin(): void
    {
        $user = User::factory()->create([
            'is_admin' => true,
            'roles' => [UserRole::SuperUser->value],
        ]);

        $this->actingAs($user)
            ->get('/admin/health-check-results')
            ->assertStatus(200);
    }

    public function test_health_page_is_denied_to_non_admin(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $this->actingAs($user)
            ->get('/admin/health-check-results')
            ->assertStatus(403);
    }

    public function test_health_page_is_protected(): void
    {
        $this->get('/admin/health-check-results')
            ->assertRedirect('/admin/login');
    }
}
