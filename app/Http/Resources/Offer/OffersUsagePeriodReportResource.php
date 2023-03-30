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
namespace App\Http\Resources\Offer;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * OffersUsagePeriodReportResource
 */
class OffersUsagePeriodReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request // Request
     * 
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "title" => $this->getTranslations('title'),
            'count' => $this->bookings_count,
            'payment_online_count'=>$this->payment_online_count,
            'payment_cash_count'=>$this->payment_cash_count,
            
        ];
    }
}
