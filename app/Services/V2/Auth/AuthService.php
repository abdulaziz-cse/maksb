<?php

namespace App\Services\V2\Auth;

use App\Models\V2\User\User;
use App\Traits\AuthHelperTrait;
use Illuminate\Support\Facades\Auth;
use App\Services\V2\User\UserService;
use App\Enums\Auth\VerificationAction;
use App\Validators\Auth\UserValidator;
use App\Services\V2\Auth\VerificationService;
use App\Exceptions\InvalidCredentialsException;
use App\Exceptions\InvalidPhoneCredentialsException;
use App\Services\V2\Auth\SmsProvider\SmsProviderFactory;

class AuthService
{
    use AuthHelperTrait;

    public function __construct(
        private UserService $userService,
        private SmsProviderFactory $smsProviderFactory,
        private VerificationService $verificationService,
    ) {
    }

    /**
     * Login a user.
     *
     * @param  array $credentials
     * @return array
     *
     * @throws InvalidCredentialsException
     */
    public function login($credentials): array
    {
        // Attempt to log in the user
        if (!Auth::attempt($credentials)) {
            throw new InvalidCredentialsException();
        }

        // Retrieve the authenticated user
        $user = Auth::user();

        if (!$user->phone_verified_at) {
            throw new InvalidPhoneCredentialsException();
        }

        return $this->generateToken($user);
    }

    public function generateToken($user): array
    {
        $token = $user->createToken('web_app_maksb_token')->plainTextToken;

        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('sanctum.expiration', 60) * 60,
        ];
    }

    public function refreshToken(): array
    {
        // Get the authenticated user
        $user = Auth::user();

        // Revoke the current token
        $user->currentAccessToken()->delete();

        // Return the new token in the response
        return $this->generateToken($user);
    }

    public function logout(): void
    {
        Auth::user()->currentAccessToken()->delete();
    }

    public function register(array $userData): User
    {
        $userData['password'] = $this->cryptPassword($userData['password']);

        $user = $this->userService->createOne($userData);

        // Assign user role
        $user->assignRole('consumer');

        return $user;
    }

    public function resetPassword(array $requestData): void
    {
        $code = $requestData['code'];
        $phone = $requestData['phone'];
        $action = VerificationAction::RESET_PASSWORD->value;

        $user = $this->userService->getOneByPhone($requestData['phone']);
        UserValidator::throwExceptionIfPhoneNotVerified($user);

        $this->verificationService->handleCodeVerification($phone, $code, $action);

        $userData = [
            'password' => $this->cryptPassword($requestData['password']),
        ];
        $user = $this->userService->updateOne($userData, $user);
    }
}
