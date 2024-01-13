<?php

namespace App\Services;

use App\Contracts\Repositories\BuyerRepositoryInterface;
use App\Models\Buyer;

class BuyerService
{
    private $buyerRepository;

    public function __construct(BuyerRepositoryInterface $buyerRepository)
    {
        $this->buyerRepository = $buyerRepository;
    }

    public function store(array $data) : Buyer
    {
        $buyerData = $data;
        unset($buyerData['file'],$buyerData['project_id']);
        $buyerData['user_id'] = auth('sanctum')->user()->id;
        $buyer = $this->buyerRepository->store($data,$buyerData);
        $buyer->load(['projects','file']);
        return $buyer;
    }

    public function getList(int $user_id)
    {
        return $this->buyerRepository->getList($user_id);
    }

    public function show(int $id)
    {
        return $this->buyerRepository->get($id);
    }
}
