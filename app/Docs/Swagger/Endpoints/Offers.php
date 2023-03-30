<?php

namespace Docs\Swagger\Definitions;

class Offers
{

    /**
     * @SWG\Get(
     *     operationId="getAllOffers",
     *     summary="List all offers",
     *     path="/offers",
     *     tags={"Offers"},
     *     @SWG\Parameter(
     *         name="lang",
     *         description="language select en/ar",
     *         required=true,
     *         in="query",
     *         type="string",
     *         @SWG\Schema(
     *              example="en",
     *         )
     *      ),
     *      @SWG\Response(
     *          response="200",
     *          description="For Home Data as ['offers']",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Offer")
     *              ),
     *          )
     *      )
     * )
     */

    /**
     * @SWG\Get(
     *     operationId="getAllTopOffers",
     *     summary="all offers that achieved all three conditions",
     *     path="/topoffers",
     *     tags={"Offers"},
     *     @SWG\Parameter(
     *         name="lang",
     *         description="language select en/ar",
     *         required=true,
     *         in="query",
     *         type="string",
     *         @SWG\Schema(
     *              example="en",
     *         )
     *      ),
     *      @SWG\Response(
     *          response="200",
     *          description="get top offers when offer achieves all these three conditions top_offer => 1, status => 1 and available => [start_at < currentDate < end_at",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Offer")
     *              ),
     *          )
     *      )
     * )
     */

}
