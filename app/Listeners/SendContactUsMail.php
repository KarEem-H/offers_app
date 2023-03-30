<?php

/**
 * Created by VsCode.
 * php version 8.0
 * Date: 25/2/23
 * Time: 01:30 م
 *
 * @category CodeSniffer
 * @author   karim <karim.hemida>
 */

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use App\Mail\ContactUsMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Setting;

/**
 * SendContactUsMail
 */
class SendContactUsMail
{

    public $queue = 'contactus';

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
     * @param  object  $event // event contact_us_email
     *
     * @return void
     */
    public function handle($event)
    {
        $setting = Setting::where('bu_id', request()->header('BU-ID'))
            ->where([['group', 'Site'], ['key', 'site.contact_us_email']])
            ->first();
        $to = $setting->value;
        if ($to) {
            try {
                Mail::to($to)->send(new ContactUsMail($event->contact));
            } catch (\Throwable $th) {
                Log::error($th->getMessage());
            }
        } else {
            Log::error('Please fill contact us mail in dashboard settings in order to receive contact us mails');
        }
    }
}
