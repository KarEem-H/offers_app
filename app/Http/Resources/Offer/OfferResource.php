<?php

namespace App\Http\Resources\Offer;

use App\Services\TamaraService;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "title" => $this->getTranslations('title'),
            "slug" => $this->getTranslations('slug'),
            "price" => $this->price,
            "order" => $this->order,
            "status" => $this->status,
            "offer_note" => $this->getTranslations('offer_note'),
            "discount_percentage" => $this->discount_percentage,
            "discount_price" => $this->discount_price,
            "image" => $this->photo,
            "top_offer_image" => $this->top_offer_image,
            "small_description" => $this->getTranslations('small_description'),
            "description" => $this->getTranslations('description'),
            "image_title" => $this->image_title,
            "image_alt" => $this->image_alt,
            "top_offer" => $this->top_offer,
            // "clinics" =>    ClinicResource::collection($this->availableClinics()),
            // "services" =>   $this->when($this->relationLoaded('services'), $this->services->count() ? ServiceResource::collection($this->services) : ServiceResource::collection($this->availableClinics()->pluck('services')->unique('id')->flatten()) ),
            // "doctors" =>    $this->when($this->relationLoaded('doctors'), $this->doctors->count()  ?  DoctorResource::collection($this->doctors) : DoctorResource::collection($this->availableClinics()->pluck('doctors')->unique('id')->flatten()) ),
            // "category" =>   $this->when($this->relationLoaded('category'), new OfferCategoryResource($this->category) ) ,
            "start_at" => $this->start_at->format('d-M-Y'),
            "end_at" => $this->end_at->format('d-M-Y'),
            "campaign" =>  $this->getTranslations('campaign'),
            'meta_keywords' => $this->getTranslations('meta_keywords'),
            'meta_description' => $this->getTranslations('meta_description'),
            "meta_title" => $this->getTranslations('meta_title'),
            "facebook_title" => $this->facebook_title,
            "facebook_description" => $this->facebook_description,
            "facebook_image" => url('/storage/' . str_replace("\\", '/', $this->facebook_image)),
            "twitter_title" => $this->twitter_title,
            "twitter_description" => $this->twitter_description,
            "twitter_image" => url('/storage/' . str_replace("\\", '/', $this->twitter_image)),
            // 'payment_types' => $this->discount_price ? resolve(TamaraService::class)->paymentTypes($this->discount_price) : []
        ];
    }
}
