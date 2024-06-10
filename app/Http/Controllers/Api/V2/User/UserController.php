<?php

namespace App\Http\Controllers\Api\V2\User;

use App\Models\V2\User\User;
use Illuminate\Http\JsonResponse;
use App\Services\V2\User\UserService;
use App\Http\Resources\V2\User\UserResource;
use App\Http\Controllers\Api\V2\BaseApiController;
use App\Http\Requests\Api\V2\User\UserUpdateRequest;

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
        $data = $request->validated();
        $user = $this->service->updateProfile($data, $user);

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
