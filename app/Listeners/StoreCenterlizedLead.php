<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class StoreCenterlizedLead implements ShouldQueue
{
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

        $lead = $event->lead;
        if ($lead->leadable_type !== 'Risks' || $lead->leadable_type !== 'Risk') {
            $offerName = "";

            if ($lead->leadable_type === 'App\Models\Offer') {
                $offerName = $lead->leadable->title_ar ?? "-";
            } else if ($lead->leadable_type === 'App\Models\OfferLandingPage') {
                $offerName = $lead->leadable->name ?? "-";
            }

            $bookingStatus = request()->has('payment') && request()->payment == 0 ? 'booked' : 'pending';

            try {
                $url = config('survey.url').'/api/'. config('survey.lead_end_point');
                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                $headers = ["Content-Type: application/json", "Accept: application/json"];
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

                $data = json_encode(array_merge($lead->toArray(), [
                    'business_unit' => config('app.business_unit'),
                    'topic' => $offerName,
                    'booking_status' => $bookingStatus
                    ]));

                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

                //for debug only!
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                $resp = curl_exec($curl);
                curl_close($curl);
                info($resp);
                info($url);
            } catch (\Exception $e) {
                info($url);
                Log::error($e->getMessage());
            }
        }
    }
}
