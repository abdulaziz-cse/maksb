<?php

namespace App\Validators\Auth;

use App\Enums\Auth\VerificationAction;
use App\Exceptions\ValidationException;

class UserValidator
{
    public static function throwExceptionIfPhoneVerified($user, $actionType)
    {
        if ($user->phone_verified_at && $actionType == VerificationAction::VERIFY_PHONE->value) {
            throw new ValidationException('The Phone already verified!');
        }
    }

    public static function throwExceptionIfUserNotExist($user)
    {
        if (!$user->phone) {
            throw new ValidationException('The Phone does not exist!');
        }
    }

    public static function throwExceptionIfPhoneNotVerified($user)
    {
        if (is_null($user->phone_verified_at)) {
            throw new ValidationException('The Phone should be verified!');
        }
    }
}
