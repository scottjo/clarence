<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class UserManagementFilamentTest extends TestCase
{
    use RefreshDatabase;

    public function test_env_super_user_can_manage_users_in_filament(): void
    {
        config(['app.super_user_email' => 'super@example.com']);

        $superUser = User::factory()->create([
            'email' => 'super@example.com',
            'is_admin' => false,
            'roles' => [],
        ]);

        $this->actingAs($superUser);

        Livewire::test(ListUsers::class)
            ->assertStatus(200);

        Livewire::test(CreateUser::class)
            ->fillForm([
                'name' => 'Question Moderator',
                'email' => 'moderator@example.com',
                'password' => 'password123',
                'is_admin' => false,
                'roles' => [UserRole::QuestionModerator->value, UserRole::QuestionAnswerer->value],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $createdUser = User::query()->where('email', 'moderator@example.com')->firstOrFail();

        $this->assertTrue($createdUser->hasRole(UserRole::QuestionModerator));
        $this->assertTrue($createdUser->hasRole(UserRole::QuestionAnswerer));

        Livewire::test(EditUser::class, [
            'record' => $createdUser->id,
        ])
            ->fillForm([
                'roles' => [UserRole::QuestionAnswerer->value],
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $createdUser->refresh();

        $this->assertFalse($createdUser->hasRole(UserRole::QuestionModerator));
        $this->assertTrue($createdUser->hasRole(UserRole::QuestionAnswerer));
    }

    public function test_administrator_cannot_manage_users_in_filament(): void
    {
        $this->actingAs(User::factory()->create([
            'roles' => [UserRole::Administrator->value],
        ]));

        Livewire::test(ListUsers::class)
            ->assertForbidden();
    }
}
