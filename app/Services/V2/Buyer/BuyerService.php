<?php

namespace App\Services\V2\Buyer;

use App\Models\V2\Buyer\Buyer;
use App\Enums\Buyer\BuyerStatus;
use App\Enums\Project\ProjectStatus;
use App\Http\Mappers\Offer\OfferMapper;
use App\Http\Mappers\Project\ProjectMapper;
use App\Services\V2\Project\ProjectService;
use App\Interfaces\BuyerRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Services\V2\Settings\PredefinedValueService;
use App\Validators\Offer\OfferValidator;

class BuyerService
{
    public function __construct(
        private BuyerRepositoryInterface $buyerRepositoryInterface,
        private PredefinedValueService $predefinedValueService,
        private ProjectService $projectService,
        private OfferMapper $offerMapper,
        private ProjectMapper $projectMapper,
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
        OfferValidator::throwExceptionIfOfferNotPending($buyer);

        $acceptedStatusId = $this->predefinedValueService->getOneBySlug(BuyerStatus::ACCEPTED->value)?->id;
        $rejectedStatusId = $this->predefinedValueService->getOneBySlug(BuyerStatus::REJECTED->value)?->id;
        $accpeptedProjectStatusId = $this->predefinedValueService->getOneBySlug(ProjectStatus::ACCEPTED->value)?->id;

        if ($requestData['is_accepted']) {
            $this->update($this->offerMapper->toSaveStatusParam($acceptedStatusId), $buyer);

            $this->projectService->update(
                $this->projectMapper->toSaveAcceptedProject($accpeptedProjectStatusId, $buyer->user),
                $buyer->project
            );
        } else {
            $this->update($this->offerMapper->toSaveStatusParam($rejectedStatusId), $buyer);
        }

        return $buyer;
    }
}
