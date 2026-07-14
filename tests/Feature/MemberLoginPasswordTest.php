<?php

namespace Tests\Feature;

use App\Livewire\MembersArea;
use App\Models\KnownMemberEmail;
use App\Models\User;
use App\Notifications\NewUserApprovalRequested;
use App\Notifications\RegistrationAwaitingApproval;
use App\Notifications\UserApprovedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use Tests\TestCase;

class MemberLoginPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_member_can_login_with_email_address_and_password(): void
    {
        $user = User::factory()->create([
            'email' => 'member@example.com',
        ]);

        Livewire::test(MembersArea::class)
            ->set('loginIdentifier', 'Member@Example.com')
            ->set('loginPassword', 'password')
            ->call('login')
            ->assertHasNoErrors()
            ->assertSet('isAuthenticated', true);

        $this->assertAuthenticatedAs($user);
    }

    public function test_members_login_page_loads_livewire_assets_and_login_form(): void
    {
        $this->get(route('members'))
            ->assertOk()
            ->assertSee('livewire.js', false)
            ->assertSee('wire:submit.prevent="login"', false)
            ->assertSee('wire:model="loginIdentifier"', false);
    }

    public function test_member_can_login_with_eight_character_numeric_password(): void
    {
        $user = User::factory()->create([
            'email' => 'jon_scott@mac.com',
            'password' => Hash::make('12345678'),
        ]);

        Livewire::test(MembersArea::class)
            ->set('loginIdentifier', 'jon_scott@mac.com')
            ->set('loginPassword', '12345678')
            ->call('login')
            ->assertHasNoErrors()
            ->assertSet('isAuthenticated', true);

        $this->assertAuthenticatedAs($user);
    }

    public function test_member_can_login_with_name_and_password(): void
    {
        $user = User::factory()->create([
            'name' => 'Jane Member',
        ]);

        Livewire::test(MembersArea::class)
            ->set('loginIdentifier', 'Jane Member')
            ->set('loginPassword', 'password')
            ->call('login')
            ->assertHasNoErrors()
            ->assertSet('isAuthenticated', true);

        $this->assertAuthenticatedAs($user);
    }

    public function test_member_cannot_login_with_incorrect_credentials(): void
    {
        User::factory()->create([
            'email' => 'member@example.com',
        ]);

        Livewire::test(MembersArea::class)
            ->set('loginIdentifier', 'member@example.com')
            ->set('loginPassword', 'wrong-password')
            ->call('login')
            ->assertHasErrors(['loginIdentifier'])
            ->assertSet('isAuthenticated', false);

        $this->assertGuest();
    }

    public function test_member_registration_requests_super_admin_approval(): void
    {
        Notification::fake();
        config(['app.super_user_email' => 'super@example.com, second-super@example.com']);

        Livewire::test(MembersArea::class)
            ->call('showRegister')
            ->set('name', 'New Member')
            ->set('email', 'new-member@example.com')
            ->set('password', 'secret-password')
            ->set('passwordConfirmation', 'secret-password')
            ->call('register')
            ->assertHasNoErrors()
            ->assertSet('isAuthenticated', false)
            ->assertSet('registrationSubmitted', true)
            ->assertSet('registrationApproved', false)
            ->assertSet('formMode', 'login');

        $user = User::query()->where('email', 'new-member@example.com')->firstOrFail();

        $this->assertDatabaseHas(User::class, [
            'name' => 'New Member',
            'email' => 'new-member@example.com',
            'approved_at' => null,
        ]);
        $this->assertGuest();

        Notification::assertSentTo($user, RegistrationAwaitingApproval::class);
        Notification::assertSentOnDemand(NewUserApprovalRequested::class, function (NewUserApprovalRequested $notification, array $channels, object $notifiable): bool {
            return $notifiable->routes['mail'] === 'super@example.com';
        });
        Notification::assertSentOnDemand(NewUserApprovalRequested::class, function (NewUserApprovalRequested $notification, array $channels, object $notifiable): bool {
            return $notifiable->routes['mail'] === 'second-super@example.com';
        });
    }

    public function test_member_registration_auto_approves_known_email_address(): void
    {
        Notification::fake();
        config(['app.super_user_email' => 'super@example.com']);

        KnownMemberEmail::factory()->create([
            'email' => 'known-member@example.com',
        ]);

        Livewire::test(MembersArea::class)
            ->call('showRegister')
            ->set('name', 'Known Member')
            ->set('email', 'Known-Member@Example.com')
            ->set('password', 'secret-password')
            ->set('passwordConfirmation', 'secret-password')
            ->call('register')
            ->assertHasNoErrors()
            ->assertSet('isAuthenticated', false)
            ->assertSet('registrationSubmitted', true)
            ->assertSet('registrationApproved', true)
            ->assertSet('formMode', 'login');

        $user = User::query()->where('email', 'known-member@example.com')->firstOrFail();

        $this->assertTrue($user->isApproved());
        $this->assertGuest();

        Notification::assertSentTo($user, UserApprovedNotification::class);
        Notification::assertSentOnDemandTimes(NewUserApprovalRequested::class, 0);
    }

    public function test_pending_member_cannot_login_until_approved(): void
    {
        User::factory()->pendingApproval()->create([
            'email' => 'pending@example.com',
        ]);

        Livewire::test(MembersArea::class)
            ->set('loginIdentifier', 'pending@example.com')
            ->set('loginPassword', 'password')
            ->call('login')
            ->assertHasErrors(['loginIdentifier'])
            ->assertSet('isAuthenticated', false);

        $this->assertGuest();
    }
}
