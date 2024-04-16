<?php

namespace App\Http\Controllers\Api\V1\Project;

use App\Models\Project;
use App\Traits\GeneralTrait;
use App\Services\Project\ProjectService;
use App\Http\Resources\Project\ProjectResource;
use App\Http\Controllers\Api\V1\BaseApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Http\Resources\Project\ProjectIndexResource;
use App\Http\Requests\Api\V1\Project\ProjectIndexRequest;
use App\Http\Requests\Api\V1\Project\ProjectManageRequest;

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

    public function store(ProjectManageRequest $request)
    {
        $data = $request->validated();
        $project = $this->projectService->store($data);
        return response()->json($project);
    }

    public function show(Project $project): JsonResponse
    {
        return $this->returnDate(
            new ProjectResource($project),
            'Project data send successfully.'
        );
    }

    public function destroy(int $id)
    {
        $this->projectService->destroy($id);
        return response()->json([
            'message' => 'Project removed successfully',
        ]);
    }
}
