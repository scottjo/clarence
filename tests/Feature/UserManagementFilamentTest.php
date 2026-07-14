<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Filament\Resources\KnownMemberEmails\Pages\CreateKnownMemberEmail;
use App\Filament\Resources\KnownMemberEmails\Pages\ListKnownMemberEmails;
use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Models\KnownMemberEmail;
use App\Models\User;
use App\Notifications\UserApprovedNotification;
use Filament\Actions\Testing\TestAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
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
        $this->assertTrue($createdUser->isApproved());

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

    public function test_env_super_user_can_approve_pending_user_in_filament(): void
    {
        Notification::fake();
        config(['app.super_user_email' => 'super@example.com']);

        $superUser = User::factory()->create([
            'email' => 'super@example.com',
            'is_admin' => false,
            'roles' => [],
        ]);
        $pendingUser = User::factory()->pendingApproval()->create([
            'email' => 'pending@example.com',
        ]);

        $this->actingAs($superUser);

        Livewire::test(ListUsers::class)
            ->callAction(TestAction::make('approve')->table($pendingUser))
            ->assertHasNoActionErrors();

        $this->assertTrue($pendingUser->fresh()->isApproved());
        Notification::assertSentTo($pendingUser, UserApprovedNotification::class);
    }

    public function test_env_super_user_can_manage_known_member_emails_in_filament(): void
    {
        config(['app.super_user_email' => 'super@example.com']);

        $superUser = User::factory()->create([
            'email' => 'super@example.com',
            'is_admin' => false,
            'roles' => [],
        ]);

        $this->actingAs($superUser);

        Livewire::test(ListKnownMemberEmails::class)
            ->assertStatus(200);

        Livewire::test(CreateKnownMemberEmail::class)
            ->fillForm([
                'email' => 'Known-Member@Example.com',
                'name' => 'Known Member',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas(KnownMemberEmail::class, [
            'email' => 'known-member@example.com',
            'name' => 'Known Member',
        ]);
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
