<?php

namespace App\Contracts\Repositories;

interface LookUpRepositoryInterface
{
    public function asset();
    public function country();
    public function currency();
    public function package();
    public function revenueSource();
    public function buyerType();
    public function buyerStatus();
}
