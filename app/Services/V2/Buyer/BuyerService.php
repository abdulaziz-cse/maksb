<?php

namespace App\Services\V2\Buyer;

use App\Models\V2\Buyer\Buyer;
use App\Enums\Buyer\BuyerStatus;
use App\Enums\Project\ProjectStatus;
use App\Services\V2\Project\ProjectService;
use App\Interfaces\BuyerRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Services\V2\Settings\PredefinedValueService;

class BuyerService
{
    public function __construct(
        private BuyerRepositoryInterface $buyerRepositoryInterface,
        private PredefinedValueService $predefinedValueService,
        private ProjectService $projectService,
    ) {
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

    public function updateStatus(array $requestData, Buyer $buyer): Buyer
    {
        $acceptedStatusId = $this->predefinedValueService->getOneBySlug(
            BuyerStatus::ACCEPTED->value
        )?->id;

        $rejectedStatusId = $this->predefinedValueService->getOneBySlug(
            BuyerStatus::REJECTED->value
        )?->id;

        $accpeptedProjectStatusId = $this->predefinedValueService->getOneBySlug(
            ProjectStatus::ACCEPTED->value
        )?->id;

        if ($requestData['is_accepted']) {
            $data['status_id'] = $acceptedStatusId;
            $this->update($data, $buyer);
            $this->projectService->updateProjectsByStatus($buyer->projects, $accpeptedProjectStatusId);
        } else {
            $data['status_id'] = $rejectedStatusId;
            $this->update($data, $buyer);
        }

        return $buyer;
    }
}
