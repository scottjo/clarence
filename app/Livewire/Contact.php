<?php

namespace App\Livewire;

use Livewire\Attributes\RateLimit;
use Livewire\Component;

class Contact extends Component
{
    public string $name = '';

    public string $email = '';

    public string $subject = '';

    public string $message = '';

    public bool $success = false;

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email',
        'subject' => 'required|min:5',
        'message' => 'required|min:10',
    ];

    #[RateLimit(5, 60)]
    public function submit()
    {
        $this->validate();

        // In a real application, you would send an email here.
        // Mail::to('admin@clarencebowls.com')->send(new ContactFormSubmitted($this->all()));

        $this->reset(['name', 'email', 'subject', 'message']);
        $this->success = true;
    }

    public function render()
    {
        return view('livewire.contact')->layout('layouts.app');
    }
}
