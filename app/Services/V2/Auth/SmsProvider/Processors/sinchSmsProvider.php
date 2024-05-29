<?php

namespace App\Services\V2\Auth\SmsProvider\Processors;

use App\Interfaces\SmsProvider;

class sinchSmsProvider implements SmsProvider
{
    private string $key;
    private string $secret;

    public const VERIFICATION_CODE_EXPIRED = 'expired';
    public const VERIFICATION_CODE_INVALID = 'invalid';
    public const VERIFICATION_CODE_VALID = 'valid';

    private $sinchVerificationUrl = 'https://verification.api.sinch.com/verification/v1/verifications';

    private $sinchSmsApiUrl = 'https://us.sms.api.sinch.com/xms/v1';

    public function __construct()
    {
        $this->loadSinchCredentials();
    }

    /**
     * Send Verification Otp
     *
     * @param  mixed $to
     * @return
     */
    public function sendVerificationOtp($to)
    {
        try {
        } catch (\Exception $e) {
            // throw new \Exception('Failed to send verification code, ' . $e->getMessage());
        }
    }

    /**
     * Verify Otp
     *
     * @param  mixed $phoneNumber
     * @param  mixed $verificationCode
     * @return
     */
    public function verifyOtp($phoneNumber, $verificationCode)
    {
        try {
        } catch (\Exception $e) {
            // throw new \Exception('Failed to verify code, ' . $e->getMessage());
        }
    }

    private function loadSinchCredentials()
    {
        $this->key = config('services.sinch.sinch_key');
        $this->secret = config('services.sinch.sinch_secret');
    }


    // public function sendVerificationCode(string $phone, string $action): bool
    // {
    //     $code = $this->generateVerificationCode();

    //     VerificationCode::create([
    //         'phone' => $phone,
    //         'code' => $code,
    //         'action' => $action,
    //         'created_at' => now(),
    //     ]);

    //     $successful = $this->sendOtpSms($phone, $code, $action . '-' . $code);

    //     if (!$successful) {
    //         throw new \Exception('Failed to send verification code');
    //     }

    //     return true;
    // }

    // public function generateVerificationCode(): string
    // {
    //     $allowedChars = '0123456789abcdefghijklmnopqrstuvwxyz';
    //     return strtoupper(substr(str_shuffle($allowedChars), 0, 5));
    // }

    // public function sendOtpSms(string $phone, string $code, string $reference): bool
    // {
    //     $sinchKey = config('maksb.sinch_key');
    //     $sinchSecret = config('maksb.sinch_secret');

    //     $phone = $this->formatPhoneNumber($phone);

    //     $response = Http::withHeaders([
    //         'Content-Type' => 'application/json',
    //         'Authorization' => 'Basic ' . base64_encode($sinchKey . ':' . $sinchSecret),
    //     ])->post($this->sinchVerificationUrl, [
    //         'method' => 'sms',
    //         'identity' => [
    //             'type' => 'number',
    //             'endpoint' => $phone,
    //         ],
    //         'reference' => $reference,
    //     ]);

    //     return $response->successful();
    // }

    // public function sinchVerifyOtp(string $phone, string $code): array
    // {
    //     $sinchKey = config('maksb.sinch_key');
    //     $sinchSecret = config('maksb.sinch_secret');

    //     $phone = $this->formatPhoneNumber($phone);

    //     $response = Http::withHeaders([
    //         'Content-Type' => 'application/json',
    //         'Authorization' => 'Basic ' . base64_encode($sinchKey . ':' . $sinchSecret),
    //     ])->put($this->sinchVerificationUrl . '/number/' . $phone, [
    //         'method' => 'sms',
    //         'sms' => [
    //             'code' => $code,
    //         ],
    //     ]);

    //     $result = (array) json_decode((string)$response->getBody(), true);

    //     return $result;
    // }
}
