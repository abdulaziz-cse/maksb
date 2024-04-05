<?php

namespace App\Services;

use Twilio\Rest\Client;
use App\Contracts\SmsProviderInterface;

class TwilioService implements SmsProviderInterface
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );
    }

    /**
     * Send SMS
     *
     * @param  mixed $to
     * @param  mixed $message
     * @return bool
     */
    public function sendSms($to, $message): bool
    {
        try {
            $this->client->messages->create(
                $to,
                [
                    'from' => config('services.twilio.phone_number'),
                    'body' => $message
                ]
            );
            return true;
        } catch (\Exception $e) {
            //  Handle the error
            throw new \Exception($e->getMessage());
            return false;
        }
    }

    /**
     * Send Verification OTP
     *
     * @param  mixed $to
     * @param  mixed $message
     *
     * @link https://www.twilio.com/docs/verify/api#step-2-send-a-verification-token Send a Verification Token.
     *
     * @return bool
     */
    public function sendVerificationOtp($to): bool
    {
        try {
            $this->client->verify->v2->services(config('services.twilio.verify_sid'))
                ->verifications
                ->create($to, "sms");
            return true;
        } catch (\Exception $e) {
            //  Handle the error
            return false;
        }
    }

    /**
     * Verify OTP
     *
     * @param  mixed $phone_number
     * @param  mixed $verification_code
     *
     * @link https://www.twilio.com/docs/verify/api#step-3-check-the-verification-token Check the Verification Token.
     *
     * @return bool
     */
    public function verifyOtp($phone_number, $verification_code): bool
    {
        try {
            $verification = $this->client->verify->v2->services(config('services.twilio.verify_sid'))
                ->verificationChecks->create(array('code' => $verification_code, 'to' => $phone_number));
            if ($verification->valid) {
                return true;
            }
            return false;
        } catch (\Exception $e) {
            //  Handle the error
            return false;
        }
    }
}
