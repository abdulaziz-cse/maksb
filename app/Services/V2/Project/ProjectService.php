<?php

namespace App\Services\V2\Project;

use App\Models\V2\Project;
use App\Interfaces\ProjectRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ProjectService
{
    public function __construct(private ProjectRepositoryInterface $projectRepositoryInterface)
    {
    }

    public function getMany($projectFilters): LengthAwarePaginator
    {
        return $this->projectRepositoryInterface->getMany($projectFilters);
    }

    public function create(array $data): Project
    {
        return $this->projectRepositoryInterface->create($data);
    }

    public function update(array $projectData, Project $project): Project
    {
        return $this->projectRepositoryInterface->update($projectData, $project);
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
