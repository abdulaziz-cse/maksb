<?php

namespace App\Services;

use App\Models\User;
use App\Models\VerificationCode;
use App\Enums\VerificationAction;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;
use App\Contracts\SmsProviderInterface;
use App\Contracts\Repositories\UserRepositoryInterface;

class AuthService
{
    public const VERIFICATION_CODE_EXPIRED = 'expired';
    public const VERIFICATION_CODE_INVALID = 'invalid';
    public const VERIFICATION_CODE_VALID = 'valid';

    /**
     * smsProvider
     *
     * @var \App\Services\TwilioService $smsProvider
     */
    private $smsProvider;

    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository, SmsProviderInterface $smsProvider)
    {
        $this->userRepository = $userRepository;
        $this->smsProvider = $smsProvider;
    }

    public function sendVerificationCode(string $phone, string $action): bool
    {
        $phone = $this->formatPhoneNumber($phone);

        $result = $this->smsProvider->sendVerificationOtp($phone);

        if (!$result) {
            throw new \Exception('Failed to send verification code');
        }

        return true;
    }

    public function verifyCode($data): string
    {
        $phone = $this->formatPhoneNumber($data['phone']);

        $result = $this->smsProvider->verifyOtp($phone, $data['code']);
        if (!$result) {
            return self::VERIFICATION_CODE_INVALID;
        }

        $user = $this->userRepository->getFirst('phone', $data['phone']);
        if ($user) {
            $user->phone_verified_at = now();
            $user->save();
        }

        if (auth('sanctum')->check()) {
            $userId = auth('sanctum')->id();
            // Store a redis key for 24 hours that this phone is verified
            // Used for profile update
            Redis::set('user_' . $userId . '_verified_' . $data['phone'], 1, 'EX', 24 * 60 * 60);
        }

        return self::VERIFICATION_CODE_VALID;
    }

    public function resetPassword($data): void
    {
        $verifyCode = $this->verifyCode([
            'phone' => $data['phone'],
            'code' => $data['code'],
            'action' => VerificationAction::RESET_PASSWORD->value,
        ]);

        if ($verifyCode !== self::VERIFICATION_CODE_VALID) {
            abort(403, 'Reset code ' . $verifyCode);
        }

        User::where('phone', $data['phone'])->update([
            'password' => \Hash::make($data['password']),
        ]);

        VerificationCode::where([
            'phone' => $data['phone'],
            'action' => VerificationAction::RESET_PASSWORD->value,
        ])->delete();
    }

    public function generateVerificationCode(): string
    {
        $allowedChars = '0123456789abcdefghijklmnopqrstuvwxyz';
        return strtoupper(substr(str_shuffle($allowedChars), 0, 5));
    }


    public function formatPhoneNumber(string $phone): string
    {
        if (strpos($phone, '0') === 0) {
            return preg_replace('/0/', '+966', $phone, 1);
        } elseif (strpos($phone, '+9660') === 0) {
            return preg_replace('/\+9660/', '+966', $phone, 1);
        } elseif (strpos($phone, '+966') === false) {
            return '+966' . $phone;
        }

        return $phone;
    }
}
