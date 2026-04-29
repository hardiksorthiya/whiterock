<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUsSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $contact;

    public function __construct(array $contact)
    {
        $this->contact = $contact;
    }

    public function build(): self
    {
        $subject = $this->contact['subject'] ?? 'New Contact Enquiry';

        return $this->subject('New Contact Enquiry - ' . $subject)
            ->view('emails.contact-us-submitted');
    }
}

