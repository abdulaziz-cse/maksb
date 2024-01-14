<?php

namespace App\Providers;

use App\Contracts\Repositories\BuyerRepositoryInterface;
use App\Contracts\Repositories\CategoryRepositoryInterface;
use App\Contracts\Repositories\FavouriteRepositoryInterface;
use App\Contracts\Repositories\LookUpRepositoryInterface;
use App\Contracts\Repositories\OrderRepositoryInterface;
use App\Contracts\Repositories\ProjectRepositoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;

use App\Repositories\BuyerRepositories;
use App\Repositories\CategoryRepositories;
use App\Repositories\FavouriteRepositories;
use App\Repositories\LookUpRepositories;
use App\Repositories\OrderRepositories;
use App\Repositories\ProjectRepositories;
use App\Repositories\UserRepositories;

use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(FavouriteRepositoryInterface::class, FavouriteRepositories::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepositories::class);

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
