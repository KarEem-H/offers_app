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

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Requests\API\{OfferRequest};
use App\Events\{OfferDeleted};
use App\Models\Offer;
use App\Models\MobileBranch;
use App\Helpers\FileHelper;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Offer\{
    DashboardOfferResource,
    RelatedOfferResource,
    DashboardOfferDetailsResource,
    OffersUsagePeriodReportResource
};
use App\Http\Resources\Api\Dashboard\{
    MobileBranchResource,
    MobileCategoryResource
};
use App\Http\Resources\{ErrorResource, SuccessResource};
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\MobileCategory;
use App\Services\OfferService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

/**
 * Class OfferController
 *
 * @package App\Http\Controllers\API
 */

class OfferController extends AppBaseController
{
    public $model;
    protected $offerService;

    /**
     * __construct
     *
     * @param OfferService $offerService //OfferService
     *
     * @return void
     */
    public function __construct(OfferService $offerService)
    {
        $this->model        = new Offer;
        $this->offerService = $offerService;
    }


    /**
     * Offers Index
     *
     * @return AnonymousResourceCollection|ErrorResource
     */
    public function index()
    {
        try {

            return DashboardOfferResource::collection($this->offerService->getAllOffers());
        } catch (\Exception $ex) {
            return new ErrorResource(Response::HTTP_BAD_REQUEST, $ex->getMessage());
        }
    }

    /**
     * Related Offers Index
     *
     *
     * @return AnonymousResourceCollection|ErrorResource
     */
    public function relatedOffers()
    {
        try {

            return RelatedOfferResource::collection($this->offerService->relatedOffers());
        } catch (\Exception $ex) {
            return new ErrorResource(Response::HTTP_BAD_REQUEST, $ex->getMessage());
        }
    }

    /**
     * Display the specified Offer.
     *
     * @param Offer $offer // the Offer
     *
     * @return SuccessResource|ErrorResource
     */
    public function show(Offer $offer)
    {
        try {
            return new SuccessResource(
                Response::HTTP_OK,
                'Offers retrieved successfully',
                new DashboardOfferDetailsResource($offer)
            );
        } catch (\Exception $ex) {
            return new ErrorResource(
                Response::HTTP_BAD_REQUEST,
                $ex->getMessage()
            );
        }
    }


    /**
     * Store offer
     *
     * @param OfferRequest $request // OfferRequest
     *
     * @return SuccessResource|ErrorResource
     */
    public function store(OfferRequest $request)
    {
        try {

            $input = $request->all();
            $input['mobile_branch_ids'] =  $this->offerService->validateMobileBranchIds(
                request()->mobile_branch_ids
            );
            $input = $this->handleRequest($input);
            $offer =  $this->offerService->storeOffer($input);

            return new SuccessResource(
                Response::HTTP_CREATED,
                'Offer created successfully',
                $offer
            );
        } catch (\Exception $ex) {
            return new ErrorResource(
                Response::HTTP_BAD_REQUEST,
                is_object(
                    json_decode($ex->getMessage())
                ) ? json_decode($ex->getMessage()) :
                    $ex->getMessage(),
                is_object(
                    json_decode($ex->getMessage())
                ) ? json_decode($ex->getMessage(), true) :
                    $ex->getMessage()
            );
        }
    }

    /**
     * Update offer
     *
     * @param Offer        $offer   // offer id
     * @param OfferRequest $request // OfferRequest
     *
     * @return SuccessResource|ErrorResource
     */
    public function update(Offer $offer, OfferRequest $request)
    {
        try {

            $this->model = $offer;
            $input       = $request->all();
            $input['mobile_branch_ids'] = $this->offerService->validateMobileBranchIds(
                request()->mobile_branch_ids
            );
            $input = $this->handleRequest($input);
            $offer =  $this->offerService->updateOffer($offer, $input);

            return new SuccessResource(
                Response::HTTP_OK,
                'Offer updated successfully',
                $offer
            );
        } catch (\Exception $ex) {
            return new ErrorResource(
                Response::HTTP_BAD_REQUEST,
                is_object(
                    json_decode($ex->getMessage())
                ) ? json_decode($ex->getMessage()) :
                    $ex->getMessage(),
                is_object(
                    json_decode($ex->getMessage())
                ) ? json_decode($ex->getMessage(), true) :
                    $ex->getMessage()
            );
        }
    }



    /**
     * Destroy
     *
     * @param Offer $offer //Offer id
     *
     * @return SuccessResource|ErrorResource
     */
    public function destroy(Offer $offer)
    {
        try {
            DB::beginTransaction();
            FileHelper::deleteMedia($offer);
            OfferDeleted::dispatch($offer);

            $offer->mobileBranches()->sync([]);
            $offer->delete();
            return new SuccessResource(Response::HTTP_NO_CONTENT, 'Offer deleted successfully');
        } catch (\Exception $ex) {
            DB::commit();
            return new ErrorResource(Response::HTTP_BAD_REQUEST, $ex->getMessage());
        }
    }


    /**
     * ActiveOfferAtHomepage
     *
     * @param Offer $offer   // Offer id
     * @param mixed $request //request
     *
     * @return SuccessResource|ErrorResource
     */
    public function activeOfferAtHomepage(Offer $offer, Request $request)
    {
        try {

            $offer =  $this->offerService->activeOfferAtHomepage($offer, $request);

            return new SuccessResource(
                Response::HTTP_OK,
                'Offers Active at home HomePage status updated successfully',
                new DashboardOfferDetailsResource($offer)
            );
        } catch (\Exception $ex) {
            return new ErrorResource(
                Response::HTTP_BAD_REQUEST,
                is_object(
                    json_decode($ex->getMessage())
                ) ? json_decode($ex->getMessage()) :
                    $ex->getMessage()
            );
        }
    }
    /**
     * ActiveOfferAsTopOffer
     *
     * @param Offer $offer   // Offer id
     * @param Request $request //request
     *
     * @return SuccessResource|ErrorResource
     */
    public function activeOfferAsTopOffer(Offer $offer, Request $request)
    {
        try {

            $offer =  $this->offerService->activeOfferAsTopOffer($offer, $request);

            return new SuccessResource(
                Response::HTTP_OK,
                'Offers Active at Top offer status updated successfully',
                new DashboardOfferDetailsResource($offer)
            );
        } catch (\Exception $ex) {
            return new ErrorResource(
                Response::HTTP_BAD_REQUEST,
                $ex->getMessage(),
                is_object(
                    json_decode($ex->getMessage())
                ) ? json_decode($ex->getMessage(), true) :
                    $ex->getMessage()
            );
        }
    }

    /**
     * GetTopOffer
     *
     * @return SuccessResource|ErrorResource
     */
    public function getTopOffers()
    {
        try {
            return new OfferResource($this->offerService->getTopOffers());
        } catch (\Exception $ex) {
            return new ErrorResource(Response::HTTP_BAD_REQUEST, $ex->getMessage());
        }
    }


    /**
     * MobileCategories
     *
     * @return AnonymousResourceCollection
     */
    public function mobileCategories(): AnonymousResourceCollection
    {

        return MobileCategoryResource::collection(MobileCategory::all());
    }


    /**
     * MobileBranches
     *
     * @return AnonymousResourceCollection
     */
    public function mobileBranches(): AnonymousResourceCollection
    {
        return MobileBranchResource::collection(
            MobileBranch::where(
                'bussiness_unit',
                request('bussinessUnit')->name
            )->get()
        );
    }

    /**
     * OffersUsagePeriodReport
     *
     * @param  Request $request // Request
     * 
     * @return OffersUsagePeriodReportResource|ErrorResource
     */
    public function offersUsagePeriodReport(Request $request)
    {

        try {

            return OffersUsagePeriodReportResource::collection(
                $this->offerService->getOffersUsagePeriodReport($request)
            );
        } catch (\Exception $ex) {
            return new ErrorResource(Response::HTTP_BAD_REQUEST, $ex->getMessage());
        }
    }
}
