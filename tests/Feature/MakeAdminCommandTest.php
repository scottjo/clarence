<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MakeAdminCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_make_a_user_an_admin(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'is_admin' => false,
        ]);

        $this->artisan('clarence:make-admin test@example.com')
            ->expectsOutput('User [test@example.com] has been granted admin access.')
            ->assertExitCode(0);

        $this->assertTrue($user->fresh()->is_admin);
    }

    public function test_it_notifies_if_user_is_already_an_admin(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@example.com',
            'is_admin' => true,
        ]);

        $this->artisan('clarence:make-admin admin@example.com')
            ->expectsOutput('User [admin@example.com] is already an admin.')
            ->assertExitCode(0);

        $this->assertTrue($user->fresh()->is_admin);
    }

    public function test_it_fails_if_user_does_not_exist(): void
    {
        $this->artisan('clarence:make-admin non-existent@example.com')
            ->expectsOutput('User with email [non-existent@example.com] not found.')
            ->assertExitCode(1);
    }
}
