<?php

namespace App\Livewire;

use App\Models\UsefulContact;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class Contact extends Component
{
    public string $name = '';

    public string $email = '';

    public string $subject = '';

    public string $message = '';

    public bool $success = false;

    public Collection $usefulContacts;

    public function mount(): void
    {
        $this->usefulContacts = UsefulContact::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email',
        'subject' => 'required|min:5',
        'message' => 'required|min:10',
    ];

    public function submit(): void
    {
        $this->validate();

        // In a real application, you would send an email here.
        // Mail::to('admin@clarencebowls.com')->send(new ContactFormSubmitted($this->all()));

        $this->reset(['name', 'email', 'subject', 'message']);
        $this->success = true;
    }

    public function render(): Factory|View|\Illuminate\View\View
    {
        return view('livewire.contact')->layout('layouts.app', [
            'title' => 'Contact Us',
            'metaDescription' => 'Get in touch with Clarence Bowls Club. Contact us for membership inquiries, facility bookings, or any other questions.',
        ]);
    }
}
