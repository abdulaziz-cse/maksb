<?php

namespace App\Contracts\Repositories;

use App\Models\Buyer;

interface BuyerRepositoryInterface
{
    public function store(array $data,array $BuyerData) : Buyer;

}
