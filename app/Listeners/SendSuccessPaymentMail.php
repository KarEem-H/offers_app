<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingInvoiceUpdate;
use Illuminate\Support\Facades\Log;

class SendSuccessPaymentMail implements ShouldQueue
{

    public $queue = 'payment';

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        
        try{
            Mail::to($event->lead->email)->send(new BookingInvoiceUpdate($event->lead));
        }catch(\Exception $e){
            Log::error($e->getMessage());
        }
    }
}
