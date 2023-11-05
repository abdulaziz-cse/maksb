<?php

namespace App\Repositories;

use App\Contracts\Repositories\GeneralRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class GeneralRepositories implements GeneralRepositoryInterface
{

    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function GetAll() :Model
    {
      return $this->model::all();
    }

    public function getOne($id) :Model
    {
       return $this->model::findOrFail($id);
    }

    public function deleteOne($id) :Model
    {
       return $this->model::destroy($id);
    }

    public function create(array $Details) :Model
    {
       return $this->model::create($Details);
    }

    public function update(int $id,array $Details) :Model
    {
        $model = $this->getOne($id);
        $model->update($Details);
        return $model;
    }

    public function getFirst($columnName,$value)
    {
        return $this->model::where($columnName,$value)->first();
    }
}
