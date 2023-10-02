<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;

class UserRepositories extends GeneralRepositories implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

}
