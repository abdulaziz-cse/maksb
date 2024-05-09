<?php

namespace App\Interfaces;

use App\Models\V2\Project;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProjectRepositoryInterface
{
    function getMany($projectFilters): LengthAwarePaginator;

    public function create(array $data): Project;

    public function update(array $projectData, Project $project): Project;

    public function getOne($projectId): ?Project;

    public function deleteOne(Project $project): bool;
}
