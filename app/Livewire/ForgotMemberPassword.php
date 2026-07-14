<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Password;
use Livewire\Component;

class ForgotMemberPassword extends Component
{
    public string $email = '';

    public bool $resetLinkSent = false;

    public function sendResetLink(): void
    {
        $validated = $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        Password::sendResetLink([
            'email' => strtolower(trim($validated['email'])),
        ]);

        $this->resetLinkSent = true;
        $this->reset('email');
    }

    public function render(): mixed
    {
        return view('livewire.forgot-member-password')
            ->layout('layouts.app', ['title' => 'Forgot Password']);
    }
}
