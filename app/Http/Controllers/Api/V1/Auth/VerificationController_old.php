<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Traits\GeneralTrait;
use App\Services\AuthService;
use App\Http\Requests\Api\V1\VerifyCodeRequest;
use App\Http\Controllers\Api\V1\BaseApiController;
use App\Http\Requests\Api\V1\SendVerificationCodeRequest;

class VerificationController extends BaseApiController
{
    use GeneralTrait;

    public function __construct(private AuthService $authService)
    {
        parent::__construct();
    }


    public function sendCode(SendVerificationCodeRequest $request)
    {
        $data = $request->validated();

        $this->authService->SendOTPByPhoneNumber($data['phone']);

        return $this->returnSuccessMessage('Verification code was sent successfully');



        // $this->authService->sendVerificationCode($data['phone'], $data['action']);
        // return response()->json([
        //     'message' => 'Verification code sent to ' . $data['phone'] . ' valid for 1 minutes.',
        // ], 200);
    }

    public function verifyCode(VerifyCodeRequest $request)
    {
        $data = $request->validated();

        $result = $this->authService->verifyCode($data);

        $statusCode = $result === AuthService::VERIFICATION_CODE_VALID ? 200 : 422;

        return response()->json([
            'message' => 'Code ' . $result,
            'result' => $result,
        ], $statusCode);
    }
}
