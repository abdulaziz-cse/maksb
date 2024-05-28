<?php

namespace App\Services\V2\Auth\SmsProvider\Processors;

use Twilio\Rest\Client;
use App\Interfaces\SmsProvider;
use App\Services\V2\Auth\SmsProvider\Models\Enums\TwilioType;

class TwilioSmsProvider implements SmsProvider
{
    protected $client;

    private string $sid;
    private string $authToken;
    private string $verifySid;

    public function __construct()
    {
        $this->loadTwilioCredentials();

        $this->client = new Client(
            $this->sid,
            $this->authToken
        );
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
            $verification  = $this->client->verify->v2->services($this->verifySid)
                ->verifications
                ->create(
                    $to,
                    TwilioType::TWILIO_SMS->value
                );

            return $verification;
        } catch (\Exception $e) {
            throw new \Exception('Failed to send verification code, ' . $e->getMessage());
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
            $verification = $this->client->verify->v2->services($this->verifySid)
                ->verificationChecks
                ->create(array(
                    'to' => $phoneNumber,
                    'code' => $verificationCode
                ));

            return $verification;
        } catch (\Exception $e) {
            throw new \Exception('Failed to verify code, ' . $e->getMessage());
        }
    }

    private function loadTwilioCredentials()
    {
        $this->sid = config('services.twilio.sid');
        $this->authToken = config('services.twilio.token');
        $this->verifySid = config('services.twilio.verify_sid');
    }
}