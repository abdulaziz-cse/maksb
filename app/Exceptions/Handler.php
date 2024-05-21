<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\JsonResponse;
use App\Exceptions\ModelNotFoundException;
use App\Exceptions\InvalidCredentialsException;
use App\Exceptions\InvalidPhoneCredentialsException;
use Illuminate\Database\QueryException as LaravelQueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException as EloquentModelNotFoundException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }


    /**
     * Render the exception into an HTTP response.
     *
     * @return JsonResponse
     */
    public function render($request, Throwable $e)
    {
        if ($e instanceof EloquentModelNotFoundException) {
            return (new ModelNotFoundException("the model not found"))->render();
        } else if ($e instanceof InvalidCredentialsException) {
            return $e->render();
        } else if ($e instanceof InvalidPhoneCredentialsException) {
            return $e->render();
        } else if ($e instanceof LaravelQueryException) {
            return (new QueryException($e->getMessage()))->render();
        } else if ($e instanceof ModelNotFoundException) {
            return $e->render();
        }
        return parent::render($request, $e);
    }
}
