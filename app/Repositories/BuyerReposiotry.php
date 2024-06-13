<?php

namespace App\Repositories;

use ErrorException;
use App\Constants\App;
use App\Models\V2\Buyer\Buyer;
use App\Enums\Buyer\BuyerStatus;
use App\Services\BuilderService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Enums\Project\ProjectStatus;
use Illuminate\Database\QueryException;
use App\Validators\Offer\OfferValidator;
use App\Interfaces\BuyerRepositoryInterface;
use App\Validators\Project\ProjectValidator;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Services\V2\Settings\PredefinedValueService;

class BuyerReposiotry implements BuyerRepositoryInterface
{
    public function __construct(
        private PredefinedValueService $predefinedValueService,
    ) {
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
        $status_id = $buyerFilters['status_id'];
        $consultant_type_id = $buyerFilters['consultant_type_id'];
        $project_id = $buyerFilters['project_id'];

        if (isset($user_id)) {
            $builder->where('user_id', $user_id);
        }

        if (isset($status_id)) {
            $builder->where('status_id', $status_id);
        }

        if (isset($consultant_type_id)) {
            $builder->where('consultant_type_id', $consultant_type_id);
        }

        if (isset($project_id)) {
            $builder->where('project_id', $project_id);
        }
    }

    /**
     * Create a buyer
     *
     * @param  mixed  $buyerData
     *
     * @throws QueryException|ErrorException
     */
    public function create(array $buyerData): Buyer
    {
        $buyerData = $this->prepareBuyerData($buyerData);
        $this->validateOffer($buyerData);

        return DB::transaction(function () use ($buyerData) {
            // Create buyer
            $buyer = $this->createOne($buyerData);

            // Add media file
            $this->addMediaFile($buyerData, $buyer);

            return $buyer->refresh();
        });
    }

    private function prepareBuyerData(array $buyerData): array
    {
        $statusId = $this->predefinedValueService->getOneBySlug(
            BuyerStatus::PENDING->value
        )?->id;

        $buyerData['user_id'] = auth(App::API_GUARD)->id();
        $buyerData['status_id'] = $statusId;

        return $buyerData;
    }

    private function addMediaFile(array $data, Buyer $buyer): void
    {
        if (!empty($data['file']))
            $buyer->addMedia($data['file'])->toMediaCollection('files');
    }

    /**
     * Update a buyer
     *
     * @param  mixed  $buyerData
     *
     * @throws QueryException|ErrorException
     */
    public function update(array $buyerData, Buyer $buyer): Buyer
    {
        return DB::transaction(function () use ($buyerData, $buyer) {
            // Update project
            $buyer = $this->updateOne($buyerData, $buyer);

            return $buyer->refresh();
        });
    }

    public function getOne($id): ?Buyer
    {
        return Buyer::findOrFail($id);
    }

    public function deleteOne(Buyer $buyer): bool
    {
        $buyer->projects()->detach();
        return $buyer->delete();
    }

    public function updateOne(array $buyerData, Buyer $buyer): Buyer
    {
        return tap($buyer)->update($buyerData);
    }

    public function createOne(array $buyerData): Buyer
    {
        return Buyer::create($buyerData)->fresh();
    }

    private function validateOffer(array $buyerData)
    {
        $offers = $this->getManyByProjectIdAndUserId(
            $buyerData['project_id'],
            $buyerData['user_id']
        );

        OfferValidator::throwExceptionIfAllOffersPending($this->isAllPending($offers));
    }

    private function isAllPending(Collection $offers): bool
    {
        return $offers->contains(function ($offer) {
            return $offer->status?->slug == BuyerStatus::PENDING->value;
        });
    }

    private function getManyByProjectIdAndUserId($projectId, $userId): Collection
    {
        return Buyer::where('project_id', $projectId)
            ->where('user_id', $userId)->get();
    }
}
