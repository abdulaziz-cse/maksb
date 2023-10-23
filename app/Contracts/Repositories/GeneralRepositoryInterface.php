<?php

namespace App\Contracts\Repositories;

interface GeneralRepositoryInterface
{
    public function GetAll();
    public function getOne($id);
    public function deleteOne($id);
    public function create(array $Details);
    public function update(int $id,array $Details);
}
