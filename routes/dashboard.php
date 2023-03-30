<?php

/**
 * Created by VsCode.
 * php version 8.0
 * Date: 25/2/23
 * Time: 01:30 م
 *
 * @category CodeSniffer
 * @author   karimhemida
 */

use App\Http\Controllers\Api\Dashboard\{
    OfferController,
    OffersCategoriesController,
   
};
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::group(
    ['prefix' => 'v1/dashboard'],
    function (): void {

        Route::group(
            ['middleware' => ['auth:sanctum', 'check_business_unit']],
            function (): void {
             
                Route::resource('offers', OfferController::class);
                Route::group(
                    ['prefix' => 'offers'],
                    function (): void {
                        Route::get('order/{order_number}', [OfferController::class, 'checkOfferOrderAlreadyTaken']);
                        Route::get('mobile/categories', [OfferController::class, 'mobileCategories']);
                        Route::get('mobile/branches', [OfferController::class, 'mobileBranches']);
                        Route::put('{offer}/homepage', [OfferController::class, 'activeOfferAtHomepage']);
                        Route::put('{offer}/topoffer', [OfferController::class, 'activeOfferAsTopOffer']);
                        Route::get('period/report', [OfferController::class, 'offersUsagePeriodReport']);
                    }
                );
                Route::get('relatedOffers', [OfferController::class, 'relatedOffers']);
                Route::get('top/offers', [OfferController::class, 'getTopOffers']);

                Route::resource('offerCategories', OffersCategoriesController::class);


            }
        );
    }
);
