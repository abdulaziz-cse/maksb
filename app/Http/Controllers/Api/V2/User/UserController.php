<?php

namespace App\Http\Controllers\Api\V2\User;

use App\Models\V2\User\User;
use Illuminate\Http\JsonResponse;
use App\Services\V2\User\UserService;
use App\Http\Resources\V2\User\UserResource;
use App\Http\Controllers\Api\V2\BaseApiController;
use App\Http\Requests\Api\V2\User\UserUpdateRequest;
use App\Http\Requests\Api\V2\User\UserUpdatePhotoRequest;
use App\Http\Requests\Api\V2\User\UserUpdatePasswordRequest;

class UserController extends BaseApiController
{
    public function __construct(private UserService $service)
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
        $userData = $request->validated();
        $user = $this->service->updateProfile($userData, $user);

        return $this->returnDate(
            new UserResource($user),
            'success'
        );
    }

    public function updatePhoto(UserUpdatePhotoRequest $request): JsonResponse
    {
        $userData = $request->validated();
        $user = $this->service->updatePhoto($userData);

        return $this->returnDate(
            new UserResource($user),
            'success'
        );
    }

    public function updatePassword(UserUpdatePasswordRequest $request): JsonResponse
    {
        $userData = $request->validated();
        $user = $this->service->updatePassword($userData);

        return $this->returnDate(
            new UserResource($user),
            'success'
        );
    }

    public function destroy(User $user): JsonResponse
    {
        $this->service->deleteOne($user);

        return $this->returnSuccessMessage('User deleted successfully');
    }
}