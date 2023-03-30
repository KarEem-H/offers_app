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

namespace App\Services;

use App\Models\Offer;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;
use \Validator;
use App\Events\{OfferCreated, OfferDeleted, OfferUpdated};
use Illuminate\Database\Eloquent\Builder;

/**
 * Class OfferService
 *
 * @package App\Services
 */
class OfferService
{

    /**
     * ShowBySlug
     *
     * @param string $slug // slug
     * 
     * @return offer
     */
    public function offerBySlug($slug)
    {
        $offer = Offer::where('bu_id', request()->header('BU-ID'))
            ->where("slug->ar", 'like', '%' . $slug . '%')
            ->orWhere("slug->en", 'like', '%' . $slug . '%')
            ->available()
            ->with('category')->first();

        if (!$offer) {
            throw new \Exception('Slug not found');
        }

        return $offer;
    }
    /**
     * FilterOffers
     *
     * @param array $parameters // parameters
     * 
     * @return LengthAwarePaginator
     */
    public function filterOffers(array $parameters): LengthAwarePaginator
    {
        $offers = Offer::withCount('bookings')
            ->whereNotNull(
                [
                    'photo', 'title', 'small_description', 'price', 'discount_price', 'start_at', 'end_at'
                ]
            )
            ->available()
            ->whereHas(
                'category',
                (function ($query) {
                    $query->where('status', true);
                })
            )
            ->where('bu_id', request()->header('BU-ID'));

        if (isset($parameters['search']) && $parameters['search'] != "") {
            $searchKey = $parameters['search'];
            $offers    = $offers->where(
                function ($query) use ($searchKey) {
                    return $query->orWhere("title->ar", 'like', '%' . $searchKey . '%')
                        ->orWhere("title->en", 'like', '%' . $searchKey . '%')
                        ->orWhere("small_description->ar", 'like', '%' . $searchKey . '%')
                        ->orWhere("small_description->en", 'like', '%' . $searchKey . '%');
                }
            );
        }

        if (isset($parameters['show_home']) && $parameters['show_home']) {
            $offers = $offers->where('show_home', true);
        }

        if (isset($parameters['top_offer']) && $parameters['top_offer']) {
            $offers = $offers->where('top_offer', 1);
        }

        $categoriesIds = isset($parameters['categories_id']) ? json_decode($parameters['categories_id']) : '';

        if ($categoriesIds) {
            $offers = $offers->whereIn('offer_category_id', $categoriesIds);
        }

        $sortKey  =  $parameters['sort_key'] ?? 'order';
        $sortType = $parameters['sort_type'] ?? 'ASC';

        $offers = $offers->orderBy($sortKey, $sortType)->paginate($parameters['limit'] ?? 6);

        return $offers;
    }

    /**
     * GetAllOffers //return all Offers to the offers table.
     *
     * @return LengthAwarePaginator
     */
    public function getAllOffers(): LengthAwarePaginator
    {
        $sortKey  = request()->sort_key ?? 'id';
        $sortType = request()->sort_type ?? 'desc';
        $keyword  = request()->search;

        $offers = Offer::select('offers.*')
            ->with(['mobileBranches', 'category'])
            ->where('offers.bu_id', request('bussinessUnit')->id)
            ->when(
                isset($keyword) && $keyword != "",
                function ($query) use ($keyword) {
                    $query->where(
                        function ($query) use ($keyword) {

                            $query->orWhere('offers.id', (int) $keyword);
                            $query->orWhere('offers.title->ar', "LIKE", '%' . $keyword . '%');
                            $query->orWhere('offers.title->en', "LIKE", '%' . $keyword . '%');
                            $query->orWhere('offers.slug->ar', "LIKE", '%' . $keyword . '%');
                            $query->orWhere('offers.slug->en', "LIKE", '%' . $keyword . '%');
                            $query->orWhere('offers.price', (int) $keyword);
                            $query->orWhere('offers.discount_price', (int) $keyword);
                            $query->orWhere('offers.start_at', "LIKE", '%' . $keyword . '%');
                            $query->orWhere('offers.end_at', "LIKE", '%' . $keyword . '%');
                            $query->orWhere('offers.order', (int) $keyword);
                            $query->orWhereHas(
                                'category',
                                function (Builder $query) use ($keyword) {
                                    $query->where("title->ar", 'like', '%' . $keyword . '%')
                                        ->orWhere("title->en", 'like', '%' . $keyword . '%');
                                }
                            );
                            $query->orWhereHas(
                                'mobileBranches',
                                function (Builder $query) use ($keyword) {
                                    $query->where("title->ar", 'like', '%' . $keyword . '%')
                                        ->orWhere("title->en", 'like', '%' . $keyword . '%');
                                }
                            );
                        }
                    );
                }
            )
            ->when(
                $sortKey == 'category',
                function ($query) use ($sortType) {

                    $query->leftjoin(
                        'offer_categories',
                        'offers.offer_category_id',
                        '=',
                        'offer_categories.id'
                    )
                        ->orderBy('offer_categories.title->' . app()->getLocale(), $sortType);
                }
            )->when(
                $sortKey == 'mobile_branches',
                function ($query) use ($sortType) {
                    $query->leftjoin(
                        'offer_mobile_branch AS offer_branch',
                        'offers.id',
                        '=',
                        'offer_branch.offer_id'
                    )->leftjoin(
                        'mobile_branches',
                        'offer_branch.mobile_branch_id',
                        '=',
                        'mobile_branches.id'
                    )->orderBy('mobile_branches.title->' . app()->getLocale(), $sortType);
                }
            )->when(
                !in_array($sortKey, ['category', 'mobile_branches']),
                function ($query) use ($sortKey, $sortType) {
                    $query->orderBy($sortKey, $sortType);
                }
            )
            ->paginate(request('limit') ?? config('app.limit'));

        return $offers;
    }



    /**
     * AllOffers //return all Offer.
     */
    public function relatedOffers()
    {
        $sortKey  = request()->sort_key ?? 'id';
        $sortType = request()->sort_type ?? 'desc';

        $offers = Offer::where('bu_id', request('bussinessUnit')->id)
            ->available()
            ->whereHas(
                'category',
                (function ($query) {
                    $query->where('status', true);
                })
            )
            ->orderBy($sortKey, $sortType)->get();

        return $offers;
    }

    /**
     * StoreOffer //array of storeOffer status.
     *
     * @param $input // request arrray.
     *
     * @return mixed
     */
    public function storeOffer($input)
    {

        $input['bu_id'] =  $input['bussinessUnit']->id;

        $order     =  request()->order ?? null;
        $isReplace = request()->is_replace ?? false;
        $newOrder  = $order;

        if (!$order) {
            // Order does not have value or exist..
            // Order not send => auto increment last order..
            $newOrder = $this->latestOrder() + 1;
        } elseif ($order) {  // Order is sended.

            // Exist => Exception error..
            if ($this->checkOfferOrderAlreadyTaken($order) > 0) {
                // The value exists..
                if (!$isReplace) {

                    // IsReplace does not exist or null.
                    throw new \Exception(
                        json_encode(
                            [
                                'message' => 'This order already taken by another offer, would you like to replace?',
                                'takenOrder' => true
                            ]
                        )
                    );
                }
                // IsReplace exist and will deleteOrderFromOffers.
                $this->deleteOrderFromOffers($order);
            } elseif ($this->checkOfferOrderAlreadyTaken($order) == 0) {
                // The value is new.
                $newOrder = $order;
            }
        }

        $input['order'] =  $newOrder;

        if (isset($input['top_offer']) && $input['top_offer']) {

            $this->uncheckOtherTopOffers();
        }
        $offer = Offer::create($input);

        if (isset($input['clinics'])) {
            $offer->clinics()->sync($input['clinics']);
        }
        if (isset($input['doctors'])) {
            $offer->doctors()->sync($input['doctors']);
        }
        if (isset($input['services'])) {
            $offer->services()->sync($input['services']);
        }
        if (isset($input['mobile_branch_ids'])) {
            $offer->mobileBranches()->sync($input['mobile_branch_ids']);
        }

        if ($offer->mobile_show && $offer->status) {
            OfferCreated::dispatch($offer);
        }

        return $offer;
    }


    /**
     * UpdateOffer
     *
     * @param mixed $offer // offer.
     * @param mixed $input // request array.
     *
     * @return mixed
     */
    public function updateOffer($offer,  $input)
    {

        $input['bu_id'] =  $input['bussinessUnit']->id;
        if ($offer->status == 0 && (isset($input['end_at']) && $input['end_at'] > Carbon::now()->format('Y-m-d'))) {
            $input['status'] = 1;
        }

        if (!isset($input['order']) || !$input['order']) {
            // Order does not have value or exist..
            // Order not send => auto increment last order..
            $input['order'] = $offer->order == $this->latestOrder() ? $offer->order : $this->latestOrder() + 1;
        } elseif (isset($input['order']) && ($offer->order != $input['order'])) {

            if ($this->checkOfferOrderAlreadyTaken($input['order']) > 0) {
                if ((isset($input['is_replace']) && !$input['is_replace']) || (!isset($input['is_replace']))) {
                    // Custom return for order replace.
                    throw new \Exception(
                        json_encode(
                            [
                                'message' => 'This order already taken by another offer, would you like to replace?',
                                'takenOrder' => true
                            ]
                        )
                    );
                }
            }

            $this->deleteOrderFromOffers($input['order'], $offer->order);
        }

        if (isset($input['top_offer']) && $input['top_offer'] && !$offer->top_offer) {

            $this->uncheckOtherTopOffers();
        }

        if (isset($input['status']) && !$input['status']) {

            $input['show_home'] = false;
        }

        $offer->update($input);

        $offer->clinics()->sync(request()->clinics);
        $offer->doctors()->sync(request()->doctors);
        $offer->services()->sync(request()->services);

        $offer->mobileBranches()->sync($input['mobile_branch_ids']);

        if ($offer->mobile_show && $offer->status) {
            OfferUpdated::dispatch($offer);
        } else {
            OfferDeleted::dispatch($offer);
        }

        return $offer;
    }

    /**
     * ActiveOfferAtHomepage
     *
     * @param offer $offer   // offer id.
     * @param mixed $request // request.
     *
     * @return mixed
     */
    public function activeOfferAtHomepage($offer, $request)
    {
        $requestArray = $request->all();

        $validation = Validator::make(
            $requestArray,
            [
                'show_home' => 'required|boolean',
            ]
        );

        if ($validation->fails()) {
            throw new \Exception(json_encode($validation->errors()));
        }

        $offersActiveAtHomecount = Offer::where('bu_id', request('bussinessUnit')->id)
            ->where('show_home', true)->count();

        if ($offersActiveAtHomecount >= 3 &&  $requestArray['show_home']) {
            throw new \Exception('Already 3 selected offers on the home page');
        }

        $offer->update(['show_home' => request()->show_home]);

        return $offer;
    }

    /**
     * activeOfferAsTopOffer
     *
     * @param offer   $offer   // offer id.
     * @param request $request // request.
     *
     * @return mixed
     */
    public function activeOfferAsTopOffer($offer, $request)
    {
        $requestArray = $request->all();

        $validation = Validator::make(
            $requestArray,
            [
                'top_offer' => 'required|boolean',
            ]
        );

        if ($validation->fails()) {
            throw new \Exception(json_encode($validation->errors()));
        }

        $offersActiveAtTopOffer = Offer::where('bu_id', request('bussinessUnit')->id)
            ->where('top_offer', true)->count();

        if ($offersActiveAtTopOffer >= 3 &&  $requestArray['top_offer']) {
            throw new \Exception('Already 3 selected offers as top offer');
        }

        $offer->update(['top_offer' => request()->top_offer]);

        return $offer;
    }


    /**
     * ValidateMobileBranchIds
     *
     * @param mixed $mobileBranchIds // mobileBranchIds
     *
     * @return array
     */
    public function validateMobileBranchIds($mobileBranchIds)
    {
        $input['mobile_branch_ids'] = json_decode($mobileBranchIds);
        $validator                  = Validator::make(
            $input,
            [
                'mobile_branch_ids' => 'required|array|min:1',
                'mobile_branch_ids.*' => 'integer|exists:mobile_branches,id'
            ]
        );

        if ($validator->fails()) {
            throw new \Exception(json_encode($validator->errors()));
        }

        return $input['mobile_branch_ids'];
    }




    /**
     * LatestOrder //return latestOrder number.
     *
     * @return int
     */
    public function latestOrder()
    {
        return Offer::where('bu_id', request('bussinessUnit')->id)
            ->orderBy('order', 'desc')->pluck('order')->first();
    }


    /**
     * CheckOfferOrderAlreadyTaken
     *
     * @param int $orderNumber // order number .
     *
     * @return int
     */
    public function checkOfferOrderAlreadyTaken($orderNumber)
    {
        return Offer::where('bu_id', request('bussinessUnit')->id)->where('order', $orderNumber)->count();
    }


    /**
     * DeleteOrderFromOffers
     *
     * @param int $orderNumber    // Offer order number.
     * @param int $oldOrderNumber // Offer order old number.
     *
     * @return mixed
     */
    public function deleteOrderFromOffers(int $orderNumber, int $oldOrderNumber = null)
    {

        return Offer::where('bu_id', request('bussinessUnit')->id)->where('order', $orderNumber)->update(
            [
                'order' =>  $oldOrderNumber ?? $this->latestOrder() + 1
            ]
        );
    }

    /**
     * GetTopOffers //return all TopOffers.
     *
     * @return LengthAwarePaginator
     */
    public function getTopOffers()
    {
        return Offer::where('bu_id', request('bussinessUnit')->id)
            ->where('top_offer', 1)->first();
    }

    /**
     * UncheckOtherTopOffers
     *
     * @return mixed
     */
    public function uncheckOtherTopOffers()
    {
        return Offer::where('bu_id', request('bussinessUnit')->id)
            ->where('top_offer', '!=', 0)->update(
                [
                    'top_offer' => 0
                ]
            );
    }

    /**
     * getOffersUsagePeriodReport
     *
     * @param string $request // request
     * 
     * @return offers
     */
    public function getOffersUsagePeriodReport($request)
    {
        $from      = $request->from;
        $to        = $request->to;
        $tableData = [];
        if ($from && $to) {

            $tableData = Offer::select('title', 'id')
                ->where('bu_id', request('bussinessUnit')->id)
                ->whereHas('bookings')
                ->withCount(['bookings' => function ($query) use ($from, $to) {
                    $query->whereBetween('created_at', [$from, $to]);
                }, 'bookings as payment_online_count' => function ($query) use ($from, $to) {
                    $query->whereBetween('created_at', [$from, $to]);
                    $query->where('payment_getway', 'not like', 'Cash_on_delivery');
                }, 'bookings as payment_cash_count' => function ($query) use ($from, $to) {
                    $query->whereBetween('created_at', [$from, $to]);
                    $query->where('payment_getway', 'like', 'Cash_on_delivery');
                }])
                ->orderBy('bookings_count', 'desc');
                // ->paginate(request('limit') ?? config('app.limit'));
        }

        if (empty($tableData)) {
            throw new \Exception('the offers not exists');
        }

        return $tableData;
    }
}
