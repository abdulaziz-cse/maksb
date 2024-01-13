<?php

namespace App\Contracts\Repositories;

use App\Models\Buyer;

interface BuyerRepositoryInterface
{
    public function getList(int $user_id);
    public function store(array $data,array $BuyerData) : Buyer;
    public function get(int $id);

}
