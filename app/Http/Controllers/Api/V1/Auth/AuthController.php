<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\V1\BaseApiController;
use App\Http\Requests\Api\V1\RegisterRequest;
use App\Http\Requests\Api\V1\LoginRequest;
use App\Http\Requests\Api\V1\ResetPasswordRequest;
use App\Services\AuthService;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseApiController
{
    public function __construct(
        private UserService $userService,
        private AuthService $authService,
    ) {
        parent::__construct();
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        if (Auth::attempt($data)) {
            $mode = config('sanctum.mode');
            $user = Auth::user();
            if ($mode === 'token') {
                $token = $user->createToken('biker');
                $user->token = $token->plainTextToken;
            }

            try {
                $request->session()->regenerate();
            } catch (\Exception $e) {
                // Not able to start session
                // Main reason is that request doesn't contain referer or origin header
                // matching sanctum stateful domains config, therefore session is not started.
            }

            return response()->json($user);
        }

        return response()->json([
            'message' => 'Invalid credentials',
        ], 401);
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = $this->userService->create($data);

        //        $this->authService->sendVerificationCode($user->phone, VerificationAction::VERIFY_PHONE->value);

        return response()->json($user);
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
