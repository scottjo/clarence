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
        'name' => 'required|min:3|max:255',
        'email' => 'required|email|max:255',
        'phoneNumber' => 'required|min:10|max:20',
        'subject' => 'required|min:5|max:255',
        'message' => 'required|min:10|max:5000',
    ];

    protected $messages = [
        'name.required' => 'Please enter your name.',
        'name.min' => 'Your name must be at least 3 characters.',
        'email.required' => 'Please enter your email address.',
        'email.email' => 'Please enter a valid email address.',
        'phoneNumber.required' => 'Please enter your phone number.',
        'phoneNumber.min' => 'Your phone number must be at least 10 characters.',
        'subject.required' => 'Please enter a subject.',
        'subject.min' => 'The subject must be at least 5 characters.',
        'message.required' => 'Please enter your message.',
        'message.min' => 'Your message must be at least 10 characters.',
        'message.max' => 'Your message must not exceed 5000 characters.',
    ];

    public function submit(): void
    {
        $this->validate();

        // Spam detection: too many capital letters in subject
        if (preg_match_all('/[A-Z]/', $this->subject) > 5) {
            $this->addError('subject', 'Your message appears to be spam. Please check your subject line.');
            $this->success = false;

            return;
        }

        $message = strtolower($this->message);

        // Spam detection: Cyrillic characters
        if ($this->isRussian($message)) {
            $this->addError('message', 'Your message appears to be spam. Please use English characters only.');
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
            ->send(new EnquiryConfirmation(
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
            'title' => 'Contact Clarence Bowls Club | Weston-super-Mare',
            'metaDescription' => 'Get in touch with Clarence Bowls Club. Contact us for membership inquiries, facility bookings, or any other questions.',
        ]);
    }

    private function isRussian($message): bool|int
    {
        return preg_match('/[А-яЁё]/u', $message);
    }
}
