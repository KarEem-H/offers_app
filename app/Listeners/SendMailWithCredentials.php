<?php

namespace App\Listeners;

use App\Events\AdminCreated;
use App\Mail\AdminCreated as MailAdminCreated;

class SendMailWithCredentials
{
    /**
     * Handle the event.
     *
     * @param  AdminCreated  $event
     * @return void
     */
    public function handle(AdminCreated $event)
    {
        \Mail::to($event->admin->email)->send(new MailAdminCreated($event->admin));
    }
}
