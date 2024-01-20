<?php

namespace App\Repositories;


use App\Contracts\Repositories\FavouriteRepositoryInterface;
use App\Models\Favourite;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class FavouriteRepositories extends GeneralRepositories implements FavouriteRepositoryInterface
{
    public function __construct(Favourite $model)
    {
        parent::__construct($model);
    }

    public function store($data) : Favourite
    {
       return $this->create($data);
    }

    public function getList($user_id)
    {
       return User::find($user_id)->projects()->with(['images','attachments','revenueSources','platforms','assets','type','category','country','currency','user','currentUserFavorite'])->get();
    }

    public function destroy($id)
    {
        return User::find(auth('sanctum')->user()->id)->projects()->detach($id);
    }

}
