<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details=$details;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $details = $this->details;
        
        $title   = $details['title'];
        $name   = $details['name'];
        $content = $details['content'];

        return $this->from('test@testgroup.net', 'test')
                    ->subject($details['title'])
                    ->view('mails.messages', compact('title','name', 'content'));
    }
}
