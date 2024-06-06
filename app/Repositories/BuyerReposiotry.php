<?php

namespace App\Repositories;

use ErrorException;
use App\Constants\App;
use App\Models\V2\Project;
use App\Models\V2\Buyer\Buyer;
use App\Enums\Buyer\BuyerStatus;
use App\Services\BuilderService;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use App\Interfaces\BuyerRepositoryInterface;
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

        if (isset($user_id)) {
            $builder->where('user_id', $user_id);
        }

        if (isset($status_id)) {
            $builder->where('status_id', $status_id);
        }

        if (isset($consultant_type_id)) {
            $builder->where('consultant_type_id', $consultant_type_id);
        }
    }

    /**
     * Create a buyer
     *
     * @param  mixed  $data
     *
     * @throws QueryException|ErrorException
     */
    public function create(array $data): Buyer
    {
        $statusId = $this->predefinedValueService->getOneBySlug(
            BuyerStatus::PENDING->value
        )?->id;

        $data['user_id'] = auth(App::API_GUARD)->id();
        $data['status_id'] = $statusId;

        return DB::transaction(function () use ($data) {
            // Create buyer
            $buyer = $this->createOne($data);

            // Attach related data
            $this->upsertProjects($data, $buyer);

            // Add media file
            $this->addMediaFile($data, $buyer);

            return $buyer->refresh();
        });
    }

    private function upsertProjects(array $data, Buyer $buyer): void
    {
        if (isset($data['project_ids'])) {
            $buyer->projects()->sync($data['project_ids']);
        }
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

            // Update related data
            $this->upsertProjects($buyerData, $buyer);

            return $buyer->refresh();
        });
    }

    public function getOne($projectId): ?Project
    {
        return Project::findOrFail($projectId);
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
}
