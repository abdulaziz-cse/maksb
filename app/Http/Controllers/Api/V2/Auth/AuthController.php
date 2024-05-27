<?php

namespace App\Http\Controllers\Api\V2\Auth;

use App\Constants\App;
use Illuminate\Http\JsonResponse;
use App\Services\V2\Auth\AuthService;
use App\Http\Resources\V2\Auth\AuthResource;
use App\Http\Requests\Api\V1\RegisterRequest;
use App\Http\Requests\Api\V2\Auth\AuthRequest;
use App\Http\Controllers\Api\V2\BaseApiController;
use App\Http\Requests\Api\V1\ResetPasswordRequest;

class AuthController extends BaseApiController
{
    public function __construct(
        // private UserService $userService,
        private AuthService $authService,
    ) {
        $this->middleware(
            'auth:sanctum',
            [
                'except' => [
                    'login',
                    'register',
                ],
            ]
        );
    }

    public function login(AuthRequest $request): JsonResponse
    {
        $credentials = $request->only('phone', 'password');
        $data = $this->authService->login($credentials);

        $data['user'] = new AuthResource(auth(App::API_GUARD)->user());

        return $this->returnDate($data, 'User Login Successfully');
    }

    public function refresh(): JsonResponse
    {
        $data = $this->authService->refreshToken();

        return $this->returnDate($data, 'User Refresh Successfully');
    }

    public function logout(): JsonResponse
    {
        $this->authService->logout();

        return $this->returnSuccessMessage('User successfully signed out');
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = $this->authService->register($data);

        return $this->returnDate(new AuthResource($user), 'User register Successfully');
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $data = $request->validated();

        $this->authService->resetPassword($data);

        return response()->json([
            'message' => 'Password reset successfully',
        ]);
    }
}