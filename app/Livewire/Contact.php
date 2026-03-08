<?php

namespace App\Livewire;

use App\Mail\Enquiry;
use App\Mail\EnquiryConfirmation;
use App\Models\UsefulContact;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Contact extends Component
{
    public string $name = '';

    public string $email = '';

    public string $phoneNumber = '';

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
        'phoneNumber' => 'required|min:10',
        'subject' => 'required|min:5',
        'message' => 'required|min:10',
    ];

    public function submit():void
    {
        $this->validate();

        if (preg_match_all("/[A-Z]/", $this->subject) > 5) {
            $this->success = false;
            return;
        }

        $message = strtolower($this->message);

        if ($this->isRussian($message)) {
            $this->success = false;
            return;
        }

        $internal_email_recipient = config('mail.internal_email_recipients');
        $from_email_address = config('mail.from.address') ?: 'enquiries@clarencebowls.org';
        $dev_email_address = config('mail.developer_address') ?: 'jon_scott@me.com';

        // In a real application, you would send an email here.
        Mail::to($internal_email_recipient)
            ->send(new Enquiry(
                name: $this->name,
                email: $this->email,
                phoneNumber: $this->phoneNumber,
                messageSubject: $this->subject,
                messageContent: $this->message,
                senderEmailAddress: $from_email_address
            ));

        Mail::to($this->email)
            ->send( new EnquiryConfirmation(
                name: $this->name,
                email: $this->email,
                phoneNumber: $this->phoneNumber,
                messageSubject: $this->subject,
                messageContent: $this->message,
                senderEmailAddress: $from_email_address
            ));

        if ($internal_email_recipient !== $dev_email_address) {
            Mail::to($dev_email_address)
                ->send(new Enquiry(
                    name: $this->name,
                    email: $this->email,
                    phoneNumber: $this->phoneNumber,
                    messageSubject: $this->subject,
                    messageContent: $this->message,
                    senderEmailAddress: $from_email_address
                ));
        }

        $this->reset(['name', 'email', 'phoneNumber', 'subject', 'message']);
        $this->success = true;
    }

    public function render(): Factory|View|\Illuminate\View\View
    {
        return view('livewire.contact')->layout('layouts.app', [
            'title' => 'Contact Us',
            'metaDescription' => 'Get in touch with Clarence Bowls Club. Contact us for membership inquiries, facility bookings, or any other questions.',
        ]);
    }

    private function isRussian($message): bool|int
    {
        return preg_match('/[А-яЁё]/u', $message);
    }
}
