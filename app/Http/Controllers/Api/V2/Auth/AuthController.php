<?php

namespace App\Http\Controllers\Api\V2\Auth;

use App\Constants\App;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Services\V2\Auth\AuthService;
use App\Http\Requests\Api\V1\LoginRequest;
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



    // public function login(AuthRequest $request): JsonResponse
    // {
    //     $data = $request->validated();

    //     if (Auth::attempt($data)) {
    //         $mode = config('sanctum.mode');
    //         $user = Auth::user();

    //         if (!$user->phone_verified_at) {
    //             return response()->json([
    //                 'message' => 'Your phone is not verified yet.',
    //             ], 403);
    //         }

    //         if ($mode === 'token') {
    //             $token = $user->createToken('biker');
    //             $user->token = $token->plainTextToken;
    //         }

    //         try {
    //             $request->session()->regenerate();
    //         } catch (\Exception $e) {
    //             // Not able to start session
    //             // Main reason is that request doesn't contain referer or origin header
    //             // matching sanctum stateful domains config, therefore session is not started.
    //         }

    //         return response()->json($user);
    //     }

    //     return response()->json([
    //         'message' => 'Invalid credentials',
    //     ], 401);
    // }

    // public function register(RegisterRequest $request)
    // {
    //     $data = $request->validated();

    //     $user = $this->userService->create($data);

    //     //        $this->authService->sendVerificationCode($user->phone, VerificationAction::VERIFY_PHONE->value);

    //     return response()->json($user);
    // }

    // public function resetPassword(ResetPasswordRequest $request)
    // {
    //     $data = $request->validated();

    //     $this->authService->resetPassword($data);

    //     return response()->json([
    //         'message' => 'Password reset successfully',
    //     ]);
    // }
}
