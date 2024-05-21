<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Traits\GeneralTrait;
use App\Services\AuthService;
use App\Http\Requests\Api\V1\Auth\VerifyCodeRequest;
use App\Http\Requests\Api\V1\Auth\SendVerificationCodeRequest;

class VerificationController
{
    use GeneralTrait;

    public function __construct(private AuthService $authService)
    {
    }

    public function sendCode(SendVerificationCodeRequest $request)
    {
        $requestData = $request->validated();

        $this->authService->sendOTPByPhoneNumber($requestData);

        return $this->returnSuccessMessage('Verification code was sent successfully.');
    }

    public function verifyCode(VerifyCodeRequest $request)
    {
        $requestData = $request->validated();

        $this->authService->VerifyOTP($requestData);

        return $this->returnSuccessMessage('Phone No: ' . $requestData['phone'] . ' was verifed successfully.');
    }
}
