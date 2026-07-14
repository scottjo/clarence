<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Component;

class ResetMemberPassword extends Component
{
    public string $token = '';

    public string $email = '';

    public string $password = '';

    public string $passwordConfirmation = '';

    public function mount(string $token): void
    {
        $this->token = $token;
        $this->email = strtolower((string) request()->query('email', ''));
    }

    public function resetPassword(): mixed
    {
        $validated = $this->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'min:8', 'same:passwordConfirmation'],
        ]);

        $status = Password::reset(
            [
                'email' => strtolower(trim($validated['email'])),
                'password' => $validated['password'],
                'password_confirmation' => $this->passwordConfirmation,
                'token' => $validated['token'],
            ],
            function (User $user, string $password): void {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            },
        );

        if ($status !== Password::PasswordReset) {
            $this->addError('email', __($status));

            return null;
        }

        session()->flash('passwordResetStatus', 'Your password has been updated. You can now sign in with your new password.');

        return $this->redirectRoute('members', navigate: true);
    }

    public function render(): mixed
    {
        return view('livewire.reset-member-password')
            ->layout('layouts.app', ['title' => 'Reset Password']);
    }
}
