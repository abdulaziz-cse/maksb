<?php
namespace App\Enums;

enum VerificationAction : string
{
    case RESET_PASSWORD = 'reset-password';
    case VERIFY_PHONE = 'verify-phone';
}
