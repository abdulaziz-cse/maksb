<?php

namespace App\Services\V2\Project;

use App\Models\V2\Project;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Interfaces\ProjectRepositoryInterface;

class ProjectService
{
    public function __construct(private ProjectRepositoryInterface $projectRepositoryInterface)
    {
        $this->projectRepositoryInterface = $projectRepositoryInterface;
    }

    public function getMany($projectFilters): LengthAwarePaginator
    {
        return $this->projectRepositoryInterface->getMany($projectFilters);
    }

    public function createOne(array $data): Project
    {
        return $this->projectRepositoryInterface->createOne($data);
    }

    public function getOne($projectId): ?Project
    {
        return $this->projectRepositoryInterface->getOne($projectId);
    }

    public function deleteOne(Project $project): bool
    {
        return $this->projectRepositoryInterface->deleteOne($project);
    }
}
