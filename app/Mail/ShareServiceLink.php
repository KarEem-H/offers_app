<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ShareServiceLink extends Mailable
{
    use Queueable, SerializesModels;

    public $to;
    public $link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $link)
    {
        // $this->to = $to;
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       
        $link = $this->link;

        return $this->subject('Service Shared Link')->view('mails.serviceLink',compact('link'));

    }
}
