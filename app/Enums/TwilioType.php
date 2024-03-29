<?php

namespace App\Enums;

enum TwilioType: string
{
    case TWILIO_SMS = 'sms';
    case TWILIO_EMAIL = 'email';
}
