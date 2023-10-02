<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\V1\BaseApiController;
use App\Http\Requests\Api\V1\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends BaseApiController
{
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
}
