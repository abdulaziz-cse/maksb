<?php

namespace App\Services\Auth;

use App\Models\VerificationCode;

class VerificationService
{
    public function createOne($verificationData): VerificationCode
    {
        return VerificationCode::create($verificationData)->fresh();
    }

    public function updateOne($verificationData, $verificationCode): VerificationCode
    {
        return tap($verificationCode)->update($verificationData);
    }

    public function getOneByPhone($phone)
    {
        return VerificationCode::where('phone', $phone)->first();
    }
}
