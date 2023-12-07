<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        Nova::createUserUsing(function ($command) {
            return [
                $command->ask('Name'),
                $command->ask('Email Address'),
                $command->ask('Phone Number'),
                $command->choice('Role', ['Super-Admin', 'Admin', 'Consumer'], 1),
                $command->choice('Type', [1 => 'Seller', 2=> 'Buyer'], 1),
                $command->secret('Password'),
            ];
        }, function ($name, $email, $phone, $role,$type, $password) {
            $emailExists = User::where('email', $email)->exists();
            if ($emailExists) {
                throw new \Exception('Email address already exists.');
            }

            $phoneExists = User::where('phone', $phone)->exists();
            if ($phoneExists) {
                throw new \Exception('Phone number already exists.');
            }

            $user = (new User)->forceFill([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'password' => $password,
                'email_verified_at' => now(),
                'phone_verified_at' => now(),
                'type_id' => $type=='Seller' ? 1:2
            ]);

            $user->save();

            $user->assignRole(strtolower(str_replace(' ', '', $role)));
        });

        Nova::footer(function ($request) {
            return Blade::render('
            Powered By Maksb.com
        ');
        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return $user->hasAnyRole(['admin', 'super-admin']);
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
