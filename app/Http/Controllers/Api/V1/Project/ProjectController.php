<?php

namespace App\Http\Controllers\Api\V1\Project;

use App\Http\Controllers\Api\V1\BaseApiController;
use App\Http\Requests\Api\V1\ProjectRequest;
use App\Services\ProjectService;
use Illuminate\Http\Request;


class ProjectController extends BaseApiController
{
    public function __construct(private ProjectService $projectService)
    {
        parent::__construct();
    }

    public function getListForUser(Request $request)
    {
        $user_id = $request->user()->id;
        $projects = $this->projectService->getList($user_id);
        return response()->json($projects);
    }

    public function store(ProjectRequest $request)
    {
        $data = $request->validated();
        $project = $this->projectService->store($data);
        return response()->json($project);
    }

    public function index(Request $request)
    {
        $data['name'] = $request->name;
        $data['category'] = $request->category;
        $data['sorting'] = $request->sorting;
        $projects = $this->projectService->index($data);
        return response()->json($projects);
    }

    public function destroy(int $id)
    {
        $this->projectService->destroy($id);
        return response()->json([
            'message' => 'Project removed successfully',
        ]);
    }

    public function show(int $id)
    {
        $project = $this->projectService->show($id);
        return response()->json($project);
    }
}
