<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\NewsletterMailContent;
use App\Mail\ManualNewsletterMail;
use Mail;
use DB;
use Illuminate\Support\Facades\Log;

class SendNewsletterMailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $mail_content;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(NewsletterMailContent $mail_content)
    {
         $this->mail_content = $mail_content;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $subscribers = $this->mail_content->subscribers()->where('is_sent', 0)->whereNotNull('email')->get();
        
        $successfully_sent = [];

        foreach ($subscribers as $subscriber) {

            try {

                Mail::to($subscriber->email)->send( new ManualNewsletterMail($this->mail_content));
                $successfully_sent[] = $subscriber->id;

            } catch (\Throwable $th) {

                Log::error($th);

            }

        }

        DB::table('newsletter_subscribers')->where('newsletter_mail_id', $this->mail_content->id)
                                            ->whereIn('subscriber_id', $successfully_sent)
                                                ->update(['is_sent' => 1]);
    }
}
