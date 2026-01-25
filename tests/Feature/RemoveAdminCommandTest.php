<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RemoveAdminCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_remove_admin_access_from_a_user(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@example.com',
            'is_admin' => true,
        ]);

        $this->artisan('clarence:remove-admin admin@example.com')
            ->expectsOutput('Admin access has been removed from user [admin@example.com].')
            ->assertExitCode(0);

        $this->assertFalse($user->fresh()->is_admin);
    }

    public function test_it_notifies_if_user_is_not_an_admin(): void
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'is_admin' => false,
        ]);

        $this->artisan('clarence:remove-admin user@example.com')
            ->expectsOutput('User [user@example.com] is not an admin.')
            ->assertExitCode(0);

        $this->assertFalse($user->fresh()->is_admin);
    }

    public function test_it_fails_if_user_does_not_exist(): void
    {
        $this->artisan('clarence:remove-admin non-existent@example.com')
            ->expectsOutput('User with email [non-existent@example.com] not found.')
            ->assertExitCode(1);
    }
}
