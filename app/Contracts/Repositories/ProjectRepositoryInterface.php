<?php

namespace App\Contracts\Repositories;

use App\Models\Project;

interface ProjectRepositoryInterface
{
    public function store(array $data, array $projectData): Project;
    public function destroy(int $id);
}
