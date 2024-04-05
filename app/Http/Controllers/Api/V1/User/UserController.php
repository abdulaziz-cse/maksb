<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Models\User;
use App\Traits\GeneralTrait;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\User\UserResource;
use App\Http\Requests\Api\V1\User\UserUpdateRequest;


class UserController
{
    use GeneralTrait;

    public function __construct(private UserService $userService)
    {
    }

    public function show(User $user): JsonResponse
    {
        return $this->returnDate(
            new UserResource($user),
            'User data send successfully.'
        );
    }

    public function update(UserUpdateRequest $request, User $user): JsonResponse
    {
        $data = $request->validated();
        $user = $this->userService->updateProfile($user->id, $data);

        return $this->returnDate(
            new UserResource($user),
            'success'
        );
    }
}
