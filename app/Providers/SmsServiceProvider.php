<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\SmsProviderInterface;
use App\Services\TwilioService;

class SmsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(SmsProviderInterface::class, function ($app) {
            $smsConfig = config('services.sms.default');
            switch ($smsConfig) {
                case 'twilio':
                    return new TwilioService();
                    break;
                // case 'sinch':
                //     return new SinchService();
                //     break;
                default:
                    throw new \Exception("Unknown SMS provider: $smsConfig");
            }
        });
    }
}
