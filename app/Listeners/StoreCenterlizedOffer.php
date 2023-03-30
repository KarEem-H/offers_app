<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class StoreCenterlizedOffer implements ShouldQueue
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

        $offer = $event->offer;

        try {
            $url = config('survey.url').'/api/'. config('survey.offer_store_end_point');
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $headers = ["Content-Type: application/json", "Accept: application/json"];
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $data = json_encode(array_merge($offer->toArray(), [
                'country_id'    => config('survey.country_id'),
                'domain'        => config('app.url')."/storage/",
                'business_unit' => config('app.business_unit'),
                'branches'      => $offer->mobileBranches->pluck('id'),
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
