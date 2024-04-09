<?php

namespace App\Services\Buyer;

use App\Models\Buyer;
use App\Services\BuilderService;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Contracts\Repositories\BuyerRepositoryInterface;

class BuyerService
{
    private $buyerRepository;

    public function __construct(BuyerRepositoryInterface $buyerRepository)
    {
        $this->buyerRepository = $buyerRepository;
    }

    public function getMany($buyerFilters): LengthAwarePaginator
    {
        $paginate = $buyerFilters['paginate'] ?? request()->paginate;
        $builder = Buyer::select();
        $this->buildGetManyQuery($buyerFilters, $builder);

        // Prepare sort & search filter if provided
        BuilderService::prepareFilters($buyerFilters, $builder);
        BuilderService::prepareSort($buyerFilters, $builder);

        return $builder->paginate($paginate);
    }

    private function buildGetManyQuery($buyerFilters, $builder)
    {
        $user_id = $buyerFilters['user_id'];

        if (isset($user_id)) {
            $builder->where('user_id', $user_id);
        }
    }

    public function createOne(array $data): Buyer
    {
        $buyerData = $data;
        unset($buyerData['file'], $buyerData['project_id']);
        $buyerData['user_id'] = auth('sanctum')->user()->id;
        $buyer = $this->buyerRepository->store($data, $buyerData);
        $buyer->load(['projects', 'file']);
        return $buyer;
    }
}
