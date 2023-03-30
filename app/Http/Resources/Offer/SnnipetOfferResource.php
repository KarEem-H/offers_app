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
 * SnnipetOfferResource
 */
class SnnipetOfferResource extends JsonResource
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
            "title" => $this->title,
            "slug" => $this->slug,
            "price" => $this->price,
            "discount_price" => $this->discount_price,
            "top_offer_image" => $this->top_offer_image,
            "image" => $this->photo,
            "image_alt" => $this->image_alt,
            "image_title" => $this->image_title,
        ];
    }
}
