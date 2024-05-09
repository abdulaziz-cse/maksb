<?php

namespace App\Http\Controllers\Api\V2\Project;

use App\Models\V2\Project;
use App\Services\V2\Project\ProjectService;
use App\Http\Controllers\Api\V2\BaseApiController;
use App\Http\Resources\V2\Project\ProjectResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Http\Resources\V2\Project\ProjectIndexResource;
use App\Http\Requests\Api\V2\Project\ProjectIndexRequest;
use App\Http\Requests\Api\V2\Project\ProjectManageRequest;
use App\Http\Requests\Api\V2\Project\ProjectUpdateRequest;

class ProjectController extends BaseApiController
{
    public function __construct(private ProjectService $service)
    {
    }

    public function index(ProjectIndexRequest $request): JsonResponse
    {
        $projectFilters = $request->validated();
        $projects = $this->service->getMany($projectFilters);

        return $this->returnDateWithPaginate(
            $projects,
            'success',
            ProjectIndexResource::class
        );
    }

    public function store(ProjectManageRequest $request): JsonResponse
    {
        $projectData = $request->validated();
        $project = $this->service->create($projectData);

        return $this->returnDate(
            new ProjectResource($project),
            'success'
        );
    }

    public function update(ProjectUpdateRequest $request, Project $project): JsonResponse
    {
        $projectData = $request->validated();
        $project = $this->service->update($projectData, $project);

        return $this->returnDate(
            new ProjectResource($project),
            'success'
        );
    }

    public function show(int $projectId): JsonResponse
    {
        $project = $this->service->getOne($projectId);

        return $this->returnDate(
            new ProjectResource($project),
            'Project data send successfully.'
        );
    }

    public function destroy(Project $project): JsonResponse
    {
        $this->service->deleteOne($project);

        return $this->returnSuccessMessage('Project deleted successfully.');
    }
}