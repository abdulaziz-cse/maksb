<?php

namespace App\Exceptions;

use App\Traits\GeneralTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class InvalidPhoneCredentialsException extends Exception
{
    use GeneralTrait;

    /**
     * Render the exception into an HTTP response.
     *
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        return $this->returnError('Your phone is not verified yet!', Response::HTTP_FORBIDDEN);
    }
}
