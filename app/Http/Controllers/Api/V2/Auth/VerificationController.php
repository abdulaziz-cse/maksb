<?php

namespace App\Http\Controllers\Api\V2\Auth;

use Illuminate\Http\JsonResponse;
use App\Services\V2\Auth\VerificationService;
use App\Http\Controllers\Api\V2\BaseApiController;
use App\Http\Requests\Api\V2\Auth\VerifyCodeRequest;
use App\Http\Requests\Api\V2\Auth\SendVerificationCodeRequest;

class VerificationController extends BaseApiController
{
    public function __construct(private VerificationService $service)
    {
    }

    public function sendOTP(SendVerificationCodeRequest $request): JsonResponse
    {
        $requestData = $request->validated();
        $this->service->sendOTP($requestData);

        return $this->returnSuccessMessage('Verification code was sent successfully.');
    }

    public function verifyOTP(VerifyCodeRequest $request): JsonResponse
    {
        $requestData = $request->validated();
        $this->service->verifyOTP($requestData);

        return $this->returnSuccessMessage('Phone No: ' . $requestData['phone'] . ' was verifed successfully.');
    }
}
