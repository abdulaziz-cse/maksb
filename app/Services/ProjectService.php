<?php

namespace App\Services;

use App\Contracts\Repositories\ProjectRepositoryInterface;
use App\Models\Project;
class ProjectService
{

    private $projectRepository;

    public function __construct(ProjectRepositoryInterface $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function getList(int $user_id)
    {
       return $this->projectRepository->getList($user_id);
    }

    public function store(array $data) : Project
    {
        $projectData = $data;
//        array_splice($projectData,-9);
        unset($projectData['file1'], $projectData['file2'],$projectData['file3'],$projectData['image1'], $projectData['image2'],$projectData['image3'],$projectData['assets'], $projectData['platforms'],$projectData['revenue_sources']);
        $projectData['user_id'] = auth('sanctum')->user()->id;
        $project = $this->projectRepository->store($data,$projectData);
        $project->load(['images','attachments','revenueSources','platforms','assets','type','category','country','currency','user']);
        return $project;
    }

    public function index(array $data)
    {
        return $this->projectRepository->index($data);
    }

    public function destroy(int $id)
    {
        return $this->projectRepository->destroy($id);
    }

    public function show(int $id)
    {
        return $this->projectRepository->get($id);
    }

}
