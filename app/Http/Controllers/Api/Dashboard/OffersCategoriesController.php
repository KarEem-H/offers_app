<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Requests\API\{offerCategoryRequest};
use App\Models\OfferCategory;
use App\Helpers\FileHelper;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Api\Dashboard\{OfferCategoryIndexResource};
use App\Http\Resources\{OfferCategoryResource, ErrorResource, SuccessResource};
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

/**
 * Class OffersCategoriesController
 * @package App\Http\Controllers\API
 */

class OffersCategoriesController extends AppBaseController
{
    public $model;

    public function __construct()
    {
        $this->model = new OfferCategory;
    }


    /**
     * List offerCategories
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $sort_key = request()->sort_key ?? 'id';
        $sort_type = request()->sort_type ?? 'desc';
        $keyword = request()->search;

        $offerCategories = OfferCategory::where('bu_id', request('bussinessUnit')->id)
                          ->filterGrid( $keyword, $sort_key, $sort_type)
                          ->paginate(request('limit') ?? config('app.limit'));

        return OfferCategoryIndexResource::collection($offerCategories);
    }

    /**
     * Display the specified offerCategory.
     *
     * @param  int $id
     *
     * @return SuccessResource
     */
    public function show($id)
    {
        /** @var OfferCategory $offerCategory */
        $offerCategory = OfferCategory::withCount('offers')->find($id);

        if (empty($offerCategory)) {
            return $this->sendError('offer category not found');
        }

        return new SuccessResource(Response::HTTP_OK, 'Offer Category retrieved successfully', new OfferCategoryResource($offerCategory));
    }


    /**
     * store OfferCategory
     *
     * @param  offerCategoryRequest $request
     * @return SuccessResource|ErrorResource
     */
    public function store(offerCategoryRequest $request)
    {
        try {
            $input = $request->all();
            $input = $this->handleRequest($input);
            $input['bu_id'] =  $input['bussinessUnit']->id;
            $offerCategory = OfferCategory::create($input);

            return new SuccessResource(Response::HTTP_CREATED, 'Offer Category created successfully', $offerCategory);
        } catch (\Exception $ex) {
            return new ErrorResource(Response::HTTP_BAD_REQUEST, $ex->getMessage());
        }
    }

    /**
     * update offerCategory
     *
     * @param  int $id
     * @param  Request $request
     * @return SuccessResource|ErrorResource
     */
    public function update($id, offerCategoryRequest $request)
    {
        try {
          /** @var OfferCategory $offerCategory */
          $offerCategory = OfferCategory::find($id);

          if (empty($offerCategory)) {
            return $this->sendError('offer category not found');
          }

            $this->model = $offerCategory;

            $input = $this->handleRequest($request->all());
            $input['bu_id'] =  $input['bussinessUnit']->id;
            $offerCategory->update($input);
            return new SuccessResource(Response::HTTP_ACCEPTED, 'Offer Category updated successfully', $offerCategory);
        } catch (\Exception $ex) {
            return new ErrorResource(Response::HTTP_BAD_REQUEST, $ex->getMessage());
        }
    }

    /**
     * destroy offerCategory
     *
     * @param  int $id
     * @return SuccessResource|ErrorResource
     */

    public function destroy($id)
    {
        try {
            $offerCategory = OfferCategory::find($id);
            if (empty($offerCategory)) {
                return new ErrorResource(Response::HTTP_NOT_FOUND, 'offerCategory not found');
            }
            if ( $offerCategory->offers()->exists()) {
                return new ErrorResource(Response::HTTP_BAD_REQUEST, 'This category is assigned to an offer, please delete the offer first in order to delete');
            }
            $offerCategory->delete();
            return new SuccessResource(Response::HTTP_ACCEPTED, 'OfferCategory deleted successfully');
        } catch (\Exception $ex) {
            return new ErrorResource(Response::HTTP_BAD_REQUEST, $ex->getMessage());
        }
    }
}
