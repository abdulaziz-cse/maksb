<?php

namespace App\Interfaces;

use App\Models\V2\Buyer\Buyer;
use Illuminate\Pagination\LengthAwarePaginator;

interface BuyerRepositoryInterface
{
    function getMany($buyerFilters): LengthAwarePaginator;

    public function create(array $data): Buyer;

    public function update(array $buyertData, Buyer $buyer): Buyer;

    public function deleteOne(Buyer $buyer): bool;
}