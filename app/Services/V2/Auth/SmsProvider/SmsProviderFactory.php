<?php

namespace App\Services\V2\Auth\SmsProvider;


use InvalidArgumentException;
use App\Services\V2\Auth\SmsProvider\Processors\TwilioSmsProvider;

class SmsProviderFactory
{
    public function getInstance()
    {
        $smsConfig = config('services.sms.default');

        switch ($smsConfig) {
            case 'twilio':
                return new TwilioSmsProvider();
                // case 'sinch':
                //     return new SinchService();
            default:
                throw new InvalidArgumentException("Unknown SMS provider: $smsConfig");
        }
    }
}