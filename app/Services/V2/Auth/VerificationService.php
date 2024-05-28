<?php

namespace App\Services\V2\Auth;

use App\Models\VerificationCode;
use App\Services\V2\Auth\AuthService;
use App\Services\V2\User\UserService;
use App\Services\V2\Auth\SmsProvider\SmsProviderFactory;

class VerificationService
{
    public function __construct(
        private AuthService $authService,
        private SmsProviderFactory $smsProviderFactory,
        private UserService $userService,
    ) {
    }

    public function sendOTP(array $requestData): void
    {
        $phone = $requestData['phone'];
        $phone = $this->authService->formatPhoneNumber($phone);

        $verification = $this->smsProviderFactory->getInstance()->sendVerificationOtp($phone);

        $verificationData = [
            'phone' => $requestData['phone'],
            'status' => $verification?->status,
            'action' => $requestData['action'],
            'created_at' => now()
        ];
        $this->createOne($verificationData);
    }

    public function verifyOTP($requestData): void
    {
        $phone = $requestData['phone'];
        $phone = $this->authService->formatPhoneNumber($phone);
        $code = $requestData['code'];

        $user = $this->userService->getOneByPhone($requestData['phone']);
        $verificationCode = $this->getOneByPhone($requestData['phone']);

        if (!$verificationCode || !$user) {
            throw new \Exception('the phone you are trying to verify is not exists!');
        }

        $verification = $this->smsProviderFactory->getInstance()->verifyOtp($phone, $code);

        // if (!$verification || $verification?->status != TwilioStatus::TWILIO_APPROVED->value) {
        //     throw new \Exception('Failed to verify code. try agiain later');
        // }

        $verificationData = [
            'status' => $verification?->status,
            'code' => $code,
        ];
        $this->updateOne($verificationData, $verificationCode);

        $user->phone_verified_at = now();
        $user->save();
    }

    public function createOne($verificationData): VerificationCode
    {
        return VerificationCode::create($verificationData)->fresh();
    }

    public function updateOne($verificationData, $verificationCode): VerificationCode
    {
        return tap($verificationCode)->update($verificationData);
    }

    public function getOneByPhone($phone): ?VerificationCode
    {
        return VerificationCode::where('phone', $phone)->first();
    }
}