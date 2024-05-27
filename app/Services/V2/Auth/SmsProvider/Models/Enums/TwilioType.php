<?php

namespace App\Services\V2\Auth\SmsProvider\Models\Enums;

enum TwilioType: string
{
    case TWILIO_SMS = 'sms';
    case TWILIO_EMAIL = 'email';
}