<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnquiryConfirmation extends Mailable implements \Illuminate\Contracts\Queue\ShouldQueue
{
    use Queueable, SerializesModels;

    public string $name;

    public string $email;

    public string $phoneNumber;

    public string $messageSubject;

    public string $messageContent;

    public string $senderEmailAddress;

    /**
     * Create a new message instance.
     */
    public function __construct(string $name, string $email, string $phoneNumber, string $messageSubject, string $messageContent, string $senderEmailAddress)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->messageSubject = $messageSubject;
        $this->messageContent = $messageContent;
        $this->senderEmailAddress = $senderEmailAddress;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): Mailable
    {
        return $this->view('mail.confirmation')
            ->subject('Clarence Bowls Website Enquiry Confirmation - '.$this->messageSubject)
            ->from($this->senderEmailAddress);
    }
}
