<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Api\V1\BaseApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\UserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends BaseApiController
{

    private $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function getProfile($id)
    {
        $user = $this->service->getProfile((int) $id);
        return response()->json($user);
    }

    public function updateProfile($id, UserRequest $request)
    {
        $data = $request->validated();
        $user = $this->service->updateProfile((int) $id, $data);
        return response()->json($user);
    }
}
