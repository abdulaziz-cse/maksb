<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\V1\BaseApiController;
use App\Http\Requests\Api\V1\ResetPasswordRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class ResetPasswordController extends BaseApiController
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        parent::__construct();

        $this->authService = $authService;
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
