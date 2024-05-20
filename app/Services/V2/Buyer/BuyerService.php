<?php

namespace App\Services\V2\Buyer;

use App\Models\V2\Buyer\Buyer;
use App\Interfaces\BuyerRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class BuyerService
{
    public function __construct(private BuyerRepositoryInterface $buyerRepositoryInterface)
    {
    }

    public function getMany($buyerFilters): LengthAwarePaginator
    {
        return $this->buyerRepositoryInterface->getMany($buyerFilters);
    }

    public function create(array $data): Buyer
    {
        return $this->buyerRepositoryInterface->create($data);
    }

    public function update(array $buyerData, Buyer $buyer): Buyer
    {
        return $this->buyerRepositoryInterface->update($buyerData, $buyer);
    }

    public function deleteOne(Buyer $buyer): bool
    {
        return $this->buyerRepositoryInterface->deleteOne($buyer);
    }
}