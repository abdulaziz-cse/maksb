<?php

namespace App\Interfaces;

use App\Models\User;

interface UserServiceInterface
{
    public function getOne($id): ?User;

    public function createOne($userData): User;

    public function updateOne($userData, User $user): User;

    public function deleteOne(User $user): bool;
}
