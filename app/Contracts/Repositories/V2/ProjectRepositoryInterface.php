<?php

namespace App\Contracts\Repositories\V2;

use App\Models\V2\Project;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProjectRepositoryInterface
{
    function getMany($projectFilters): LengthAwarePaginator;

    public function createOne(array $data): Project;

    public function getOne($projectId): ?Project;

    public function deleteOne(Project $project): bool;
}
