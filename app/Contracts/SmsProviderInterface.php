<?php

namespace App\Contracts;

interface SmsProviderInterface
{
    /**
     * Send SMS
     *
     * @param  mixed $to
     * @param  mixed $message
     * @return bool
     */
    public function sendSms($to, $message): bool;

    /**
     * Send Verification Otp
     *
     * @param  mixed $to
     * @return bool
     */
    public function sendVerificationOtp($to): bool;

    /**
     * Verify Otp
     *
     * @param  mixed $phone_number
     * @param  mixed $verification_code
     * @return bool
     */
    public function verifyOtp($phone_number, $verification_code): bool;
}
