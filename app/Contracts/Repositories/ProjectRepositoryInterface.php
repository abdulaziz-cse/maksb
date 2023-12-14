<?php

namespace App\Contracts\Repositories;

use App\Models\Project;

interface ProjectRepositoryInterface
{
    public function getList(int $user_id);
    public function store(array $data,array $projectData) : Project;
    public function index(array $data);
    public function destroy(int $id);
    public function get(int $id);
}
