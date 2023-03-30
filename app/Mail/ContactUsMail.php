<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contact_us;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contact_us)
    {
        $this->contact_us = $contact_us;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Contact Us')
                    ->markdown('mails.contact-us', [
                        'contact_us' => $this->contact_us,
                    ]);
    }
}
