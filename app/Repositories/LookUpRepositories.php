<?php

namespace App\Repositories;

use App\Contracts\Repositories\LookUpRepositoryInterface;
use App\Models\Asset;
use App\Models\BuyerStatus;
use App\Models\BuyerType;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Package;
use App\Models\RevenueSource;
use Illuminate\Database\Eloquent\Model;

class LookUpRepositories implements LookUpRepositoryInterface
{
    protected $model;
    /**
     * @param mixed $model
     */
    public function setModel(mixed $model): void
    {
        $this->model = $model;
    }

    public function asset()
    {
       $this->setModel(Asset::class);
        return $this->model::all();
    }

    public function country()
    {
       $this->setModel(Country::class);
        return $this->model::all();
    }

    public function currency()
    {
        $this->setModel(Currency::class);
        return $this->model::all();
    }

    public function package()
    {
        $this->setModel(Package::class);
        return $this->model::all();
    }

    public function revenueSource()
    {
        $this->setModel(RevenueSource::class);
        return $this->model::all();
    }

    public function buyerType()
    {
        $this->setModel(BuyerType::class);
        return $this->model::all();
    }

    public function buyerStatus()
    {
        $this->setModel(BuyerStatus::class);
        return $this->model::all();
    }

}
