<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Enums\VerificationAction;
use App\Http\Controllers\Api\V1\BaseApiController;
use App\Http\Requests\Api\V1\RegisterRequest;
use App\Services\AuthService;
use App\Services\UserService;
use Illuminate\Http\Request;


class RegisterController extends BaseApiController
{

    private $userService;

    private $authService;

    public function __construct(UserService $userService, AuthService $authService)
    {
        parent::__construct();

        $this->authService = $authService;
        $this->userService = $userService;
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = $this->userService->create($data);

//        $this->authService->sendVerificationCode($user->phone, VerificationAction::VERIFY_PHONE->value);

        return response()->json($user);
    }
}
