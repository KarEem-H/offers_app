<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\NewsletterMailContent;

class ManualNewsletterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mail_content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(NewsletterMailContent $mail_content)
    {
        $this->mail_content = $mail_content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        $mail_view = $this->from(config('mail.NEWSLETTER_MAIL'), 'مراكز أندلسية لطب الأسنان')
                          ->subject($this->mail_content->title);

        $mail_view = $this->mail_content->attachment ? $mail_view->attach( url( 'storage/'. $this->mail_content->attachment)  ) : $mail_view;
         
        return $mail_view->view('mails.manual_newsletter');

    }
}
