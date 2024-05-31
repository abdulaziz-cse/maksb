<?php

namespace App\Providers;


use App\Interfaces\SmsProvider;
use Illuminate\Support\ServiceProvider;
use App\Services\V2\Auth\SmsProvider\SmsProviderFactory;

class SmsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(SmsProvider::class, SmsProviderFactory::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}