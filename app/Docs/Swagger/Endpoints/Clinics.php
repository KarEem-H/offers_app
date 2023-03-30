<?php

namespace Docs\Swagger\Definitions;

class Clinics
{

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *     operationId="getAllClinics",
     *     summary="List all clinics",
     *     path="/clinics",
     *     tags={"Clinics"},
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
     *          response=200,
     *          description="Successfully get all clinics",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Clinic")
     *              ),
     *              @SWG\Property(
     *                  property="meta_tags",
     *                  type="object",
     *              ),
     *              @SWG\Property(
     *                  property="twitter_card",
     *                  type="object",
     *              ),
     *              @SWG\Property(
     *                  property="open_graph",
     *                  type="object",
     *              ),
     *          )
     *      )
     * )
     */

    /**
     * @param int $slug
     * @return Response
     *
     * @SWG\Get(
     *      path="/clinic/{slug}",
     *      summary="Display the specified Clinic",
     *      tags={"Clinics"},
     *      description="Get Clinic",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="slug",
     *          description="slug of Clinic",
     *          type="string",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Clinic"
     *              ),
     *          )
     *      )
     * )
     */

}
