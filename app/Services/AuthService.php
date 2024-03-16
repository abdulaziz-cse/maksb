<?php

namespace App\Services;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Enums\VerificationAction;
use App\Models\VerificationCode;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;

class AuthService
{
    public const VERIFICATION_CODE_EXPIRED = 'expired';
    public const VERIFICATION_CODE_INVALID = 'invalid';
    public const VERIFICATION_CODE_VALID = 'valid';

    private $sinchVerificationUrl = 'https://verification.api.sinch.com/verification/v1/verifications';

    private $sinchSmsApiUrl = 'https://us.sms.api.sinch.com/xms/v1';

    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function sendVerificationCode(string $phone, string $action): bool
    {
        $code = $this->generateVerificationCode();

        VerificationCode::create([
            'phone' => $phone,
            'code' => $code,
            'action' => $action,
            'created_at' => now(),
        ]);

        $successful = $this->sendOtpSms($phone, $code, $action.'-'.$code);

        if (! $successful) {
            throw new \Exception('Failed to send verification code');
        }

        return true;
    }

    public function verifyCode($data): string
    {
        // $data = ['phone' => '', 'code' => '', 'action' => ''];
        $sinchVerifyResult = $this->sinchVerifyOtp($data['phone'], $data['code']);

        $sinchSuccess = is_array($sinchVerifyResult) &&
            isset($sinchVerifyResult['status'], $sinchVerifyResult['reference']) &&
            $sinchVerifyResult['status'] === 'SUCCESSFUL';

        if (! $sinchSuccess) {
            return self::VERIFICATION_CODE_INVALID;
        }

        $ourCode = substr(strrchr($sinchVerifyResult['reference'], '-'), 1);

        $data['code'] = $ourCode;
        $verificationCode = VerificationCode::where($data)->latest()->first();
        if (! $verificationCode) {
            return self::VERIFICATION_CODE_INVALID;
        }

        if ($verificationCode->created_at->lt(now()->subMinutes(1))) {
            // 1 minutes passed, code expired
            return self::VERIFICATION_CODE_EXPIRED;
        }

        if (
            $verificationCode->action === VerificationAction::VERIFY_PHONE->value &&
            $user = $this->userRepository->getFirst('phone', $data['phone'])
        ) {
            $user->phone_verified_at = now();
            $user->save();
        }

        if (auth('sanctum')->check()) {
            $userId = auth('sanctum')->id();
            // Store a redis key for 24 hours that this phone is verified
            // Used for profile update
            Redis::set('user_'.$userId.'_verified_'.$data['phone'], 1, 'EX', 24 * 60 * 60);
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

    public function sendOtpSms(string $phone, string $code, string $reference): bool
    {
        $sinchKey = config('maksb.sinch_key');
        $sinchSecret = config('maksb.sinch_secret');

       $phone = $this->formatPhoneNumber($phone);

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic '.base64_encode($sinchKey.':'.$sinchSecret),
        ])->post($this->sinchVerificationUrl, [
            'method' => 'sms',
            'identity' => [
                'type' => 'number',
                'endpoint' => $phone,
            ],
            'reference' => $reference,
        ]);

        return $response->successful();
    }

    public function sinchVerifyOtp(string $phone, string $code): array
    {
        $sinchKey = config('maksb.sinch_key');
        $sinchSecret = config('maksb.sinch_secret');

       $phone = $this->formatPhoneNumber($phone);

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic '.base64_encode($sinchKey.':'.$sinchSecret),
        ])->put($this->sinchVerificationUrl.'/number/'.$phone, [
            'method' => 'sms',
            'sms' => [
                'code' => $code,
            ],
        ]);

        $result = (array) json_decode((string)$response->getBody(), true);

        return $result;
    }

    public function formatPhoneNumber(string $phone): string
    {
        if (strpos($phone, '0') === 0) {
            return preg_replace('/0/', '+966', $phone, 1);
        } elseif (strpos($phone, '+9660') === 0) {
            return preg_replace('/\+9660/', '+966', $phone, 1);
        } elseif (strpos($phone, '+966') === false) {
            return '+966'.$phone;
        }

        return $phone;
    }
}
