<?php

namespace Tests\Feature;

use App\Livewire\ForgotMemberPassword;
use App\Livewire\ResetMemberPassword;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Livewire\Livewire;
use Tests\TestCase;

class MemberPasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_members_sign_in_page_has_forgotten_password_link(): void
    {
        $this->get(route('members'))
            ->assertOk()
            ->assertSee(route('members.password.request'), false)
            ->assertSee('Forgotten password?');
    }

    public function test_member_can_request_password_reset_link(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email' => 'member@example.com',
        ]);

        Livewire::test(ForgotMemberPassword::class)
            ->set('email', 'Member@Example.com')
            ->call('sendResetLink')
            ->assertHasNoErrors()
            ->assertSet('resetLinkSent', true)
            ->assertSet('email', '');

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_password_reset_request_does_not_email_unknown_address(): void
    {
        Notification::fake();

        Livewire::test(ForgotMemberPassword::class)
            ->set('email', 'missing@example.com')
            ->call('sendResetLink')
            ->assertHasNoErrors()
            ->assertSet('resetLinkSent', true);

        Notification::assertNothingSent();
    }

    public function test_member_can_reset_password_with_valid_token(): void
    {
        $user = User::factory()->create([
            'email' => 'member@example.com',
            'password' => Hash::make('old-password'),
        ]);
        $token = Password::createToken($user);

        Livewire::test(ResetMemberPassword::class, [
            'token' => $token,
        ])
            ->set('email', 'member@example.com')
            ->set('password', 'new-password')
            ->set('passwordConfirmation', 'new-password')
            ->call('resetPassword')
            ->assertHasNoErrors()
            ->assertRedirect(route('members', absolute: false));

        $this->assertTrue(Hash::check('new-password', $user->fresh()->password));
    }
}
