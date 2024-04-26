<?php

namespace App\Http\Controllers\Api\V2\Project;

use App\Models\V2\Project;
use App\Traits\GeneralTrait;
use App\Services\V2\Project\ProjectService;
use App\Http\Controllers\Api\V1\BaseApiController;
use App\Http\Resources\V2\Project\ProjectResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Http\Resources\V2\Project\ProjectIndexResource;
use App\Http\Requests\Api\V2\Project\ProjectIndexRequest;
use App\Http\Requests\Api\V2\Project\ProjectManageRequest;

class ProjectController extends BaseApiController
{
    use GeneralTrait;

    public function __construct(private ProjectService $projectService)
    {
        parent::__construct();
    }

    public function index(ProjectIndexRequest $request): JsonResponse
    {
        $projectFilters = $request->validated();
        $projects = $this->projectService->getMany($projectFilters);

        return $this->returnDateWithPaginate(
            $projects,
            'success',
            ProjectIndexResource::class
        );
    }

    public function store(ProjectManageRequest $request): JsonResponse
    {
        $data = $request->validated();
        $project = $this->projectService->createOne($data);

        return $this->returnDate(
            new ProjectResource($project),
            'success'
        );
    }

    public function show(int $projectId): JsonResponse
    {
        $project = $this->projectService->getOne($projectId);

        return $this->returnDate(
            new ProjectResource($project),
            'Project data send successfully.'
        );
    }

    public function destroy(Project $project): JsonResponse
    {
        $this->projectService->deleteOne($project);

        return $this->returnSuccessMessage('Project deleted successfully');
    }
}
