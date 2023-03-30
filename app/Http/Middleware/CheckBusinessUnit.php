<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\BusinessUnit;
use App\Services\AdminService;
use Illuminate\Http\Response;

class CheckBusinessUnit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $bu_ID = $request->header('BU-ID');
        $businessUnit = BusinessUnit::where('id', $bu_ID)->first();

        if (!isset($bu_ID) || !$businessUnit) {
            return response()->json(['status' => false, 'message' => 'Please check business unit'], Response::HTTP_FORBIDDEN);
        }

        // Admin account related to more than BU
        // Make service to validate admin BUs
        if (!resolve(AdminService::class)->checkAdminBUs($businessUnit->name)) {
            return response()->json(['status' => false, 'message' => 'Failed, Your account is not related to business unit'], Response::HTTP_FORBIDDEN);
        }

        $request['bussinessUnit'] = $businessUnit;

        return $next($request);
    }
}
