<?php

namespace App\Exceptions;

use App\Traits\GeneralTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class InvalidCredentialsException extends Exception
{
    use GeneralTrait;

    /**
     * Render the exception into an HTTP response.
     *
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        return $this->returnError('Credentials Provided are invalid!', Response::HTTP_UNAUTHORIZED);
    }
}
