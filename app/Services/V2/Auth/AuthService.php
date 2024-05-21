<?php

namespace App\Services\V2\Auth;

use App\Models\User;
use App\Constants\App;
use Twilio\Rest\Client;
use App\Enums\TwilioType;
use App\Services\UserService;
use App\Models\VerificationCode;
// use Illuminate\Support\Facades\Redis;
use App\Enums\VerificationAction;
use App\Enums\Twilio\TwilioStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Services\Auth\VerificationService;
use App\Exceptions\InvalidCredentialsException;
use App\Exceptions\InvalidPhoneCredentialsException;
use App\Contracts\Repositories\UserRepositoryInterface;

class AuthService
{
    private string $twilioSid;
    private string $twilioAuthToken;
    private string $twilioVerifySid;

    public const VERIFICATION_CODE_EXPIRED = 'expired';
    public const VERIFICATION_CODE_INVALID = 'invalid';
    public const VERIFICATION_CODE_VALID = 'valid';

    private $sinchVerificationUrl = 'https://verification.api.sinch.com/verification/v1/verifications';

    private $sinchSmsApiUrl = 'https://us.sms.api.sinch.com/xms/v1';

    public function __construct(
        private UserRepositoryInterface $userRepository,
        private VerificationService $verificationService,
        private UserService $userService,
    ) {
        $this->loadTwilioCredentials();
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
            'expires_in' => config('sanctum.expiration') * 60,
        ];
    }

    /**
     * Refresh a user's token.
     */
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




















    public function sendVerificationCode(string $phone, string $action): bool
    {
        $code = $this->generateVerificationCode();

        VerificationCode::create([
            'phone' => $phone,
            'code' => $code,
            'action' => $action,
            'created_at' => now(),
        ]);

        $successful = $this->sendOtpSms($phone, $code, $action . '-' . $code);

        if (!$successful) {
            throw new \Exception('Failed to send verification code');
        }

        return true;
    }

    public function verifyCode($data): string
    {
        // $data = ['phone' => '', 'code' => '', 'action' => ''];
        $phone = $data['phone'];

        $verificationCode = $this->verificationService->getOneByPhone($phone);

        if (!$verificationCode) {
            return self::VERIFICATION_CODE_INVALID;
        }

        $verificationCode = VerificationCode::where($data)->latest()->first();
        if (!$verificationCode) {
            return self::VERIFICATION_CODE_INVALID;
        }

        // if ($verificationCode->created_at->lt(now()->subMinutes(1))) {
        //     // 1 minutes passed, code expired
        //     return self::VERIFICATION_CODE_EXPIRED;
        // }

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
            // Redis::set('user_' . $userId . '_verified_' . $data['phone'], 1, 'EX', 24 * 60 * 60);
        }

        return self::VERIFICATION_CODE_VALID;
    }

    public function resetPassword($data): void
    {
        $basic_phone = $data['phone'];
        $data['phone'] = $this->formatPhoneNumber($data['phone']);

        $verifyCode = $this->verifyCode([
            'phone' => $data['phone'],
            'code' => $data['code'],
            'action' => VerificationAction::RESET_PASSWORD->value,
        ]);

        if ($verifyCode !== self::VERIFICATION_CODE_VALID) {
            abort(403, 'Reset code ' . $verifyCode);
        }

        User::where('phone', $basic_phone)->update([
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
            'Authorization' => 'Basic ' . base64_encode($sinchKey . ':' . $sinchSecret),
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
            'Authorization' => 'Basic ' . base64_encode($sinchKey . ':' . $sinchSecret),
        ])->put($this->sinchVerificationUrl . '/number/' . $phone, [
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
            return '+966' . $phone;
        }

        return $phone;
    }

    private function loadTwilioCredentials()
    {
        $this->twilioSid = getenv("TWILIO_SID");
        $this->twilioAuthToken = getenv("TWILIO_AUTH_TOKEN");
        $this->twilioVerifySid = getenv("TWILIO_VERIFY_SID");
    }

    public function sendOTPByPhoneNumber($requestData): void
    {
        $phone = $requestData['phone'];
        $phone = $this->formatPhoneNumber($phone);

        $twilio = new Client($this->twilioSid, $this->twilioAuthToken);
        $verification  =  $twilio->verify->v2->services($this->twilioVerifySid)
            ->verifications
            ->create(
                $phone,
                TwilioType::TWILIO_SMS->value
            );

        if (!$verification) {
            throw new \Exception('Failed to send verification code. try agiain later');
        }

        $verificationData = [
            'phone' => $requestData['phone'],
            'status' => $verification?->status,
            'action' => $requestData['action'],
            'created_at' => now()
        ];

        $this->verificationService->createOne($verificationData);
    }

    public function VerifyOTP($requestData): void
    {
        $phone = $requestData['phone'];
        $phone = $this->formatPhoneNumber($phone);
        $code = $requestData['code'];

        $user = $this->userService->getOneByPhone($requestData['phone']);
        $verificationCode = $this->verificationService->getOneByPhone($requestData['phone']);

        if (!$verificationCode || !$user) {
            throw new \Exception('the phone you are trying to verify is not exists!');
        }

        $twilio = new Client($this->twilioSid, $this->twilioAuthToken);

        $verification = $twilio->verify->v2->services($this->twilioVerifySid)
            ->verificationChecks
            ->create(array('to' => $phone, 'code' => $code));

        if (!$verification || $verification?->status != TwilioStatus::TWILIO_APPROVED->value) {
            throw new \Exception('Failed to verify code. try agiain later');
        }

        $verificationData = [
            'status' => $verification?->status,
            'code' => $code,
        ];
        $this->verificationService->updateOne($verificationData, $verificationCode);

        $user->phone_verified_at = now();
        $user->save();
    }
}
