<?php

namespace App\Repositories;

use App\Contracts\Repositories\ProjectRepositoryInterface;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

class ProjectRepositories extends GeneralRepositories implements ProjectRepositoryInterface
{
    public function __construct(Project $model)
    {
        parent::__construct($model);
    }

    public function getList(int $user_id)
    {
        return $this->model::with(['images','attachments','revenueSources','platforms','assets','type','category','country','currency','user','currentUserFavorite'])->where('user_id',$user_id)->get();
    }

    public function get(int $id)
    {
        return $this->model::with(['images','attachments','revenueSources','platforms','assets','type','category','country','currency','user','currentUserFavorite'])->where('id',$id)->first();
    }

    public function store(array $data,array $projectData) : Project
    {
        DB::beginTransaction();

        try {
            $project = $this->create($projectData);
            $project->revenueSources()->attach($data['revenue_sources']);
            $project->platforms()->attach($data['platforms']);
            $project->assets()->attach($data['assets']);
            if (!empty($data['image1']))
                $project->addMedia($data['image1'])->toMediaCollection('images');
            if (!empty($data['image2']))
                $project->addMedia($data['image2'])->toMediaCollection('images');
            if (!empty($data['image3']))
                $project->addMedia($data['image3'])->toMediaCollection('images');
            if (!empty($data['file1']))
                $project->addMedia($data['file1'])->toMediaCollection('attachments');
            if (!empty($data['file2']))
                $project->addMedia($data['file2'])->toMediaCollection('attachments');
            if (!empty($data['file3']))
                $project->addMedia($data['file3'])->toMediaCollection('attachments');
            DB::commit();
            return $project;
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            dd($e);
        }

    }

    public function index(array $data)
    {
        $result = $this->model::with(['images','attachments','revenueSources','platforms','assets','type','category','country','currency','user','currentUserFavorite']);
        if (!empty($data['name']))
            $result = $result->where('name', 'like', '%'.$data['name'].'%');
        if (!empty($data['category']))
            $result = $result->whereIn('category_id',$data['category']);
        if (!empty($data['sorting']) and $data['sorting']==='DESC')
            $result = $result->orderBy('created_at','desc');
        else
            $result = $result->orderBy('created_at');
        $result = $result->paginate('10');

        return $result;

    }


    public function destroy(int $id)
    {
        DB::beginTransaction();

        try {
            $project = $this->getOne($id);
            $project->revenueSources()->detach();
            $project->platforms()->detach();
            $project->assets()->detach();
            $project->delete();
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollback();
            // something went wrong
        }
    }

}
