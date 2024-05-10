<?php

namespace App\Enums\Twilio;

enum TwilioStatus: string
{
    case TWILIO_APPROVED = 'approved';
    case TWILIO_PENDING = 'pending';
}