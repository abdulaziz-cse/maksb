<?php

namespace App\Enums\Auth;

enum VerificationAction: string
{
    case RESET_PASSWORD = 'reset-password';
    case VERIFY_PHONE = 'verify-phone';
}
