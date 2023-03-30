<?php

namespace App\Http\Resources\Offer;

use App\Http\Resources\Api\Dashboard\MobileBranchResource;
use App\Http\Resources\Api\Dashboard\MobileCategoryResource;
use App\Http\Resources\OfferCategoryResource;
use App\Services\TamaraService;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardOfferDetailsResource extends JsonResource
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
            "status" => $this->status?true:false,
            "show_home" => $this->show_home?true:false,
            "price"=>$this->price,
            "order"=>$this->order,
            "offer_note"=>$this->offer_note,
            "discount_percentage"=> $this->discount_percentage,
            "discount_price"=>$this->discount_price,
            "image"=> $this->photo,
            "top_offer_image"=> $this->top_offer_image,
            "description"=>$this->getTranslations('description'),
            "small_description" => $this->getTranslations('small_description'),
            "image_title"=>$this->image_title,
            "image_alt"=>$this->image_alt,
            "top_offer" => $this->top_offer,
            "category" =>  $this->category?new OfferCategoryResource($this->category->loadCount('offers')):[],
            "start_at" => $this->start_at->format('Y-m-d'),
            "end_at" => $this->end_at->format('Y-m-d'),
            "campaign" =>  $this->getTranslations('campaign'),
            'meta_keywords' => $this->getTranslations('meta_keywords'),
            'meta_description' => $this->getTranslations('meta_description'),
            "meta_title" => $this->getTranslations('meta_title'),
            "facebook_title" => $this->facebook_title,
            "facebook_description" => $this->facebook_description,
            "facebook_image" => url('/storage/'.str_replace("\\", '/', $this->facebook_image)),
            "twitter_title" => $this->twitter_title,
            "twitter_description" => $this->twitter_description,
            "twitter_image" => url('/storage/'.str_replace("\\", '/', $this->twitter_image)),
            "mobile_branches" => MobileBranchResource::collection($this->mobileBranches),
            "mobile_category" =>  $this->mobileCategory?new MobileCategoryResource($this->mobileCategory):[],
            "show_home" => $this->show_home ? true : false,
            "mobile_show" => $this->mobile_show ? true : false,
        ];
    }
}
