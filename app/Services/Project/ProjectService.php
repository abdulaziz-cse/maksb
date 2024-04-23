<?php

namespace App\Services\Project;

use App\Constants\App;
use App\Models\Project;
use App\Services\BuilderService;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Contracts\Repositories\ProjectRepositoryInterface;

class ProjectService
{
    private $projectRepository;

    public function __construct(ProjectRepositoryInterface $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function getMany($projectFilters): LengthAwarePaginator
    {
        $paginate = $projectFilters['paginate'] ?? request()->paginate;
        $builder = Project::select();

        $this->buildGetManyQuery($projectFilters, $builder);

        // Use a single method to prepare sort and filter
        BuilderService::prepareFilters($projectFilters, $builder);
        BuilderService::prepareSort($projectFilters, $builder);

        return $builder->paginate($paginate);
    }

    private function buildGetManyQuery($projectFilters, $builder)
    {
        $userId = $projectFilters['user_id'];
        $name = $projectFilters['name'];
        $category_id = $projectFilters['category_id'];

        if (isset($category_id)) {
            $builder->where('category_id', $category_id);
        }

        if (isset($name)) {
            $builder->where('name', 'like', '%' . $name . '%');
        }

        if (isset($userId)) {
            $builder->where('user_id', $userId);
        }
    }

    public function store(array $data): Project
    {
        $projectData = $data;
        //        array_splice($projectData,-9);
        unset($projectData['file1'], $projectData['file2'], $projectData['file3'], $projectData['image1'], $projectData['image2'], $projectData['image3'], $projectData['assets'], $projectData['platforms'], $projectData['revenue_sources']);
        $projectData['user_id'] = auth('sanctum')->user()->id;
        $project = $this->projectRepository->store($data, $projectData);
        $project->load(['images', 'attachments', 'revenueSources', 'platforms', 'assets', 'type', 'category', 'country', 'currency', 'user']);
        return $project;
    }

    public function destroy(int $id)
    {
        return $this->projectRepository->destroy($id);
    }

    public function getOne($projectId): ?Project
    {
        return Project::findOrFail($projectId);
    }

    public function deleteOne(Project $project): bool
    {
        $project->revenueSources()->detach();
        $project->platforms()->detach();
        $project->assets()->detach();

        return $project->delete();
    }
}
