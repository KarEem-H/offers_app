<?php

namespace App\Listeners;

use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\NewsLetter as NewsLetterMail;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewsletterMail implements ShouldQueue
{

    public $queue = 'newsletter';

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
        $subscriber = $event->subscriber;
        $mail = Setting::whereIn('key', ['general-message.message.news_letter'])->pluck('value')->first(); // to do using cache
        $detail['content']=$mail;
        $detail['title']="Analusia Group";
        
        $detail['page_name'] = $subscriber->subscription_page;
        try {

            Mail::to($subscriber->email)->send(new NewsLetterMail($detail));
            $subscriber->update(['is_sent' => true]);

        } catch (\Throwable $th) {

            Log::warning($th->getMessage());

        }
    }
}
