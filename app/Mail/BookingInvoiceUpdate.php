<?php

namespace App\Mail;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BookingInvoiceUpdate extends Mailable
{
    use Queueable, SerializesModels;

    public $lead;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($lead)
    {
        $this->lead = Lead::find($lead->id);
        info($this->lead->booking);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->cc(config('mail.MAIL_FINANCE_DEP'))
                    ->subject('ايصال حجز مستشفيات أندلسية')
                    ->markdown('mails.invoice', [
                        'lead' => $this->lead,
                    ]);
    }
}
