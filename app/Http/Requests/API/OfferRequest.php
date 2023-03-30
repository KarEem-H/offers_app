<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Offer;
use Carbon\Carbon;

class OfferRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = Offer::$rules;

        if(request()->getMethod() == 'POST'){
            return $rules;
        }

        $rules['photo'] = 'nullable|max:5000';
        $rules['top_offer_image'] = 'nullable|max:5000';

        return $rules;
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {           
            if(request()->getMethod() == 'PUT'){
                $id=request()->route()->parameter('offer');
                $requestOffer = Offer::find(gettype($id) == 'object'? $id->id:$id);
              
                if(empty($requestOffer)){
                 return $validator->errors()->add('id', "ID NOT FOUND");
                }
            }
   

            $endAt = request()->end_at;

            if ($endAt < Carbon::now()->format('Y-m-d')) {
                $validator->errors()->add('end_at', "End date must be after now");
            }

            $slugAr = request()->slug_ar;
            $slugEn = request()->slug_en;
            $offerId = (int) str_replace('/api/v1/dashboard/offers/', '', request()->requestUri);

            $offer = Offer::where(function ($query) use ($slugAr, $slugEn, $offerId) {
                $query->where("slug->ar", 'like', '%'.$slugAr.'%')
                ->orWhere("slug->en", 'like', '%'.$slugAr.'%');

                if ($slugEn != "") {
                    $query->where("slug->en", 'like', '%'.$slugEn.'%')
                            ->orWhere("slug->ar", 'like', '%'.$slugEn.'%');
                }
            })->first();

            if ($offer) {
                if (($offerId && $offer->id != $offerId) || (!$offerId)) {
                    $validator->errors()->add('slug', "Slug is already taken");
                }
            }
        });
    }
}
