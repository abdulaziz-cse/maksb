<?php

namespace App\Validators\Auth;

use App\Exceptions\ValidationException;
use App\Services\V2\Auth\SmsProvider\Models\Enums\TwilioStatus;

class VerificationCodeValidator
{
    public static function throwExceptionIfOTPNotSend($verification)
    {
        if (!$verification) {
            throw new ValidationException('The Phone doesnot receive the OTP!');
        }
    }

    public static function throwExceptionIfStatusNotApproved($verification)
    {
        if ($verification?->status != TwilioStatus::TWILIO_APPROVED->value) {
            throw new ValidationException('Failed to verify phone becasue of status: ' . $verification?->status);
        }
    }
}
