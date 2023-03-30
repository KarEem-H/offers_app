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

use App\Http\Resources\Api\Dashboard\MobileBranchResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

/**
 * OfferResource
 */
class DashboardOfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request // Request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "slug" => $this->slug,
            "price" => $this->price,
            "order" => $this->order,
            "status" => $this->status ? true : false,
            "show_home" => $this->show_home ? true : false,
            "discount_percentage" => $this->discount_percentage,
            "discount_price" => $this->discount_price,
            "top_offer" => $this->top_offer,
            "mobile_branches" => MobileBranchResource::collection($this->mobileBranches),
            "category" =>  $this->category->title ?? "",
            "start_at" => $this->start_at->format('Y-m-d'),
            "end_at" => $this->end_at->format('Y-m-d'),
            "home_page_toggle" => ($this->status
                && ($this->start_at < Carbon::now()->format('Y-m-d')
                    && $this->end_at > Carbon::now()->format('Y-m-d'))) &&
                ($this->price !=  $this->discount_price)
                ? true : false,
        ];
    }
}
