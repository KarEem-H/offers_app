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
 * OfferIndexResource
 */
class OfferIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request //  Request
     * 
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "title" => $this->getTranslations('title'),
            "slug" => $this->getTranslations('slug'),
            "price" => $this->price,
            "discount_percentage" => $this->discount_percentage,
            "discount_price" => $this->discount_price,
            "image" => $this->photo,
            'image_title' => $this->image_title,
            'image_alt' => $this->image_alt,
            "top_offer_image" => $this->top_offer_image,
            "small_description" => $this->small_description,
            "start_at" => $this->start_at->format('d-M-Y'),
            "end_at" => $this->end_at->format('d-M-Y'),
        ];
    }
}
