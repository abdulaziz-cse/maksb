<?php

namespace App\Providers;

use App\Repositories\UserRepositories;
use App\Repositories\BuyerRepositories;
use App\Repositories\OrderRepositories;
use App\Repositories\ProjectReposiotry;
use App\Repositories\SettingReposiotry;
use Illuminate\Support\ServiceProvider;

use App\Repositories\LookUpRepositories;
use App\Repositories\ProjectRepositories;
use App\Repositories\CategoryRepositories;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Repositories\BuyerRepositoryInterface;
use App\Contracts\Repositories\OrderRepositoryInterface;

use App\Contracts\Repositories\LookUpRepositoryInterface;
use App\Contracts\Repositories\ProjectRepositoryInterface;
use App\Contracts\Repositories\CategoryRepositoryInterface;
use App\Repositories\BuyerReposiotry;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepositories::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepositories::class);
        $this->app->bind(LookUpRepositoryInterface::class, LookUpRepositories::class);
        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepositories::class);
        $this->app->bind(BuyerRepositoryInterface::class, BuyerRepositories::class);
        // $this->app->bind(FavouriteRepositoryInterface::class, FavouriteRepositories::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepositories::class);

        $this->app->bind(\App\Interfaces\ProjectRepositoryInterface::class, ProjectReposiotry::class);
        $this->app->bind(\App\Interfaces\SettingRepositoryInterface::class, SettingReposiotry::class);
        $this->app->bind(\App\Interfaces\BuyerRepositoryInterface::class, BuyerReposiotry::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}