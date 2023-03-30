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
 * OfferDetailsResource
 */
class OfferDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request // request
     * 
     * @return array
     */
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "slug" => $this->slug,
            "slug_ar" => $this->slug_ar ?? "",
            "slug_en" => $this->slug_en ?? '',
            "price" => $this->price,
            "order" => $this->order,
            "offer_note" => $this->offer_note,
            "discount_percentage" => $this->discount_percentage,
            "discount_price" => $this->discount_price,
            "image" => $this->photo,
            "top_offer_image" => $this->top_offer_image,
            "description" => $this->description,
            "small_description" => $this->small_description,
            "image_title" => $this->image_title,
            "image_alt" => $this->image_alt,
            "top_offer" => $this->top_offer,
            "offer_category_id" => $this->offer_category_id,
            "start_at" => $this->start_at->format('d-M-Y'),
            "end_at" => $this->end_at->format('d-M-Y'),
            "campaign" =>  $this->campaign,
            'meta_keywords' => $this->meta_keywords,
            'meta_description' => $this->meta_description,
            "meta_title" => $this->meta_title,
            "facebook_title" => $this->facebook_title,
            "facebook_description" => $this->facebook_description,
            "facebook_image" => url('/storage/' . str_replace("\\", '/', $this->facebook_image)),
            "twitter_title" => $this->twitter_title,
            "twitter_description" => $this->twitter_description,
            "twitter_image" => url('/storage/' . str_replace("\\", '/', $this->twitter_image)),
        ];
    }
}
