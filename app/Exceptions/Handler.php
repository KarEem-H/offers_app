<?php

namespace App\Exceptions;

use App\Http\Resources\ErrorResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * render the ModelNotFoundException for the application.
     *
     * @return void
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException && $request->wantsJson()) {
            $modelName = class_basename($exception->getModel());
            return response()->json(new ErrorResource(Response::HTTP_NOT_FOUND, "$modelName not found", ['target' => "$modelName not found"]), Response::HTTP_NOT_FOUND);
        }
        return parent::render($request, $exception);
    }
}
