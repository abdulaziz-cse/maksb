<?php

namespace App\Repositories;

use App\Constants\App;
use App\Models\V2\Project;
use App\Services\BuilderService;
use Illuminate\Support\Facades\DB;
use App\Interfaces\ProjectRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ProjectReposiotry implements ProjectRepositoryInterface
{
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
        $user_id = $projectFilters['user_id'];
        $name = $projectFilters['name'];
        $category_id = $projectFilters['category_id'];

        if (isset($user_id)) {
            $builder->where('user_id', $user_id);
        }

        if (isset($category_id)) {
            $builder->where('category_id', $category_id);
        }

        if (isset($name)) {
            $builder->where('name', 'like', '%' . $name . '%');
        }
    }

    public function createOne(array $data): Project
    {
        $projectData = $this->prepareProjectData($data);

        return DB::transaction(function () use ($projectData, $data) {
            // Create project
            $project = Project::create($projectData)->fresh();

            // Attach related data
            $this->upsertRevenueSources($data, $project);
            $this->upsertPlatforms($data, $project);
            $this->upsertAssets($data, $project);

            // Add media files
            $this->addImageMediaFiles($data, $project);
            $this->addAttachmentMediaFiles($data, $project);

            return $project->refresh();
        });
    }

    private function prepareProjectData($data): array
    {
        $projectData = array_diff_key($data, array_flip(['file1', 'file2', 'file3', 'image1', 'image2', 'image3', 'assets', 'platforms', 'revenue_sources']));
        $projectData['user_id'] = auth(App::API_GUARD)->user()->id;

        return $projectData;
    }

    private function upsertRevenueSources(array $data, Project $project): void
    {
        if (isset($data['revenue_sources'])) {
            $project->revenueSources()->sync($data['revenue_sources']);
        }
    }

    private function upsertPlatforms(array $data, Project $project): void
    {
        if (isset($data['platforms'])) {
            $project->platforms()->sync($data['platforms']);
        }
    }

    private function upsertAssets(array $data, Project $project): void
    {
        if (isset($data['assets'])) {
            $project->assets()->sync($data['assets']);
        }
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

    private function addImageMediaFiles(array $data, Project $project)
    {
        $images = ['image1', 'image2', 'image3'];

        foreach ($images as $image) {
            if (!empty($data[$image]))
                $project->addMedia($data[$image])->toMediaCollection('images');
        }
    }

    private function addAttachmentMediaFiles(array $data, Project $project): void
    {
        $attachments = ['file1', 'file2', 'file3'];

        foreach ($attachments as $attachment) {
            if (!empty($data[$attachment]))
                $project->addMedia($data[$attachment])->toMediaCollection('attachments');
        }
    }
}
