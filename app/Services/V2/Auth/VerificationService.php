<?php

namespace App\Services\V2\Auth;

use App\Traits\AuthHelperTrait;
use App\Services\V2\User\UserService;
use App\Validators\Auth\UserValidator;
use App\Models\V2\Auth\VerificationCode;
use App\Constants\VerificationCodeSetting;
use App\Validators\Auth\VerificationCodeValidator;
use App\Services\V2\Auth\SmsProvider\SmsProviderFactory;

class VerificationService
{
    use AuthHelperTrait;

    public function __construct(
        private SmsProviderFactory $smsProviderFactory,
        private UserService $userService,
    ) {
    }

    public function sendOTP(array $requestData): void
    {
        $phone = $requestData['phone'];
        $phone = $this->formatPhoneNumber($phone);

        $user = $this->userService->getOneByPhone($requestData['phone']);
        UserValidator::throwExceptionIfPhoneVerified($user, $requestData['action']);

        $verification = $this->smsProviderFactory->getInstance()->sendVerificationOtp($phone);

        $verificationCode = $this->getOne(
            $requestData['phone'],
            VerificationCodeSetting::INACTIVE,
            $requestData['action']
        );

        if (!$verificationCode) {
            $verificationData = [
                'phone' => $requestData['phone'],
                'status' => $verification?->status,
                'action' => $requestData['action'],
                'created_at' => now(),
                'is_active' => VerificationCodeSetting::INACTIVE,
            ];
            $this->createOne($verificationData);
        }
    }

    public function verifyOTP($requestData): void
    {
        $code = $requestData['code'];
        $phone = $requestData['phone'];
        $action = $requestData['action'];

        $user = $this->userService->getOneByPhone($phone);
        UserValidator::throwExceptionIfUserNotExist($user);
        UserValidator::throwExceptionIfPhoneVerified($user, $action);

        $this->handleCodeVerification($phone, $code, $action);
        $this->userService->updateOne(['phone_verified_at' => now()], $user);
    }

    public function handleCodeVerification(string $phone, string $code, string $action): void
    {
        $verificationCode = $this->getOne($phone, VerificationCodeSetting::INACTIVE, $action);
        VerificationCodeValidator::throwExceptionIfOTPNotSend($verificationCode);

        $phone = $this->formatPhoneNumber($phone);

        $verification = $this->smsProviderFactory->getInstance()->verifyOtp($phone, $code);
        VerificationCodeValidator::throwExceptionIfStatusNotApproved($verification);

        $verificationData = [
            'status' => $verification?->status,
            'code' => $code,
            'is_active' => VerificationCodeSetting::ACTIVE,
        ];
        $this->updateOne($verificationData, $verificationCode);
    }

    public function createOne($verificationData): VerificationCode
    {
        return VerificationCode::create($verificationData)->fresh();
    }

    public function updateOne($verificationData, $verificationCode): VerificationCode
    {
        return tap($verificationCode)->update($verificationData);
    }

    public function getOne($phone, $isActive, $action): ?VerificationCode
    {
        return VerificationCode::where('phone', $phone)
            ->where('is_active', $isActive)
            ->where('action', $action)->first();
    }
}
