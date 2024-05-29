<?php

namespace App\Services\V2\Auth\SmsProvider\Models\Enums;

enum TwilioStatus: string
{
    case TWILIO_APPROVED = 'approved';
    case TWILIO_PENDING = 'pending';
}
