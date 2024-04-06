<?php

namespace App\Services;

use App\Contracts\Repositories\LookUpRepositoryInterface;

class LookUpService
{
    private $lookUpRepository;

    public function __construct(LookUpRepositoryInterface $lookUpRepository)
    {
        $this->lookUpRepository = $lookUpRepository;
    }

    public function asset()
    {
        return $this->lookUpRepository->asset();
    }

    public function country()
    {
        return $this->lookUpRepository->country();
    }

    public function currency()
    {
        return $this->lookUpRepository->currency();
    }

    public function package()
    {
        return $this->lookUpRepository->package();
    }
    public function revenueSource()
    {
        return $this->lookUpRepository->revenueSource();
    }

    public function buyerType()
    {
        return $this->lookUpRepository->buyerType();
    }

    public function buyerStatus()
    {
        return $this->lookUpRepository->buyerStatus();
    }
}
