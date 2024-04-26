<?php

namespace App\Services\V2\Project;

use App\Models\V2\Project;
use App\Services\BuilderService;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Contracts\Repositories\V2\ProjectRepositoryInterface;

class ProjectService implements ProjectRepositoryInterface
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
            // $this->handleMediaFiles($project, $data);

            return $project->refresh();
        });

        //        array_splice($projectData,-9);
        // unset($projectData['file1'], $projectData['file2'], $projectData['file3'], $projectData['image1'], $projectData['image2'], $projectData['image3'], $projectData['assets'], $projectData['platforms'], $projectData['revenue_sources']);
        // $projectData['user_id'] = auth('sanctum')->user()->id;
        // $project = $this->projectRepository->store($data, $projectData);
        // $project->load(['images', 'attachments', 'revenueSources', 'platforms', 'assets', 'type', 'category', 'country', 'currency', 'user']);
        // return $project;
    }

    private function prepareProjectData($data): array
    {
        $projectData = array_diff_key($data, array_flip(['file1', 'file2', 'file3', 'image1', 'image2', 'image3', 'assets', 'platforms', 'revenue_sources']));
        $projectData['user_id'] = auth('sanctum')->user()->id;

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
            $project->revenueSources()->sync($data['platforms']);
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

    // public function createOne($projectData): Project
    // {
    //     return Project::create($verificationData)->fresh();
    // }


    // public function store(array $data, array $projectData): Project
    // {
    //     return DB::transaction(function () use ($projectData, $data) {

    //         $project = $this->create($projectData);
    //         $project->revenueSources()->attach($data['revenue_sources']);
    //         $project->platforms()->attach($data['platforms']);
    //         $project->assets()->attach($data['assets']);

    //         if (!empty($data['image1']))
    //             $project->addMedia($data['image1'])->toMediaCollection('images');
    //         if (!empty($data['image2']))
    //             $project->addMedia($data['image2'])->toMediaCollection('images');
    //         if (!empty($data['image3']))
    //             $project->addMedia($data['image3'])->toMediaCollection('images');
    //         if (!empty($data['file1']))
    //             $project->addMedia($data['file1'])->toMediaCollection('attachments');
    //         if (!empty($data['file2']))
    //             $project->addMedia($data['file2'])->toMediaCollection('attachments');
    //         if (!empty($data['file3']))
    //             $project->addMedia($data['file3'])->toMediaCollection('attachments');

    //         return $project->refresh();
    //     });
    // }

    private function handleMediaFiles(Project $project, array $data)
    {
        // Define arrays for images and attachments
        $images = ['image1', 'image2', 'image3'];
        $attachments = ['file1', 'file2', 'file3'];

        // Add images to media collection
        foreach ($images as $image) {
            if (!empty($data[$image])) {
                $project->addMedia($data[$image])->toMediaCollection('images');
            }
        }

        // Add attachments to media collection
        foreach ($attachments as $attachment) {
            if (!empty($data[$attachment])) {
                $project->addMedia($data[$attachment])->toMediaCollection('attachments');
            }
        }
    }
}
