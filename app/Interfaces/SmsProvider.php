<?php

namespace App\Interfaces;

interface SmsProvider
{
    /**
     * Send Verification Otp
     *
     * @param  mixed $to
     * @return
     */
    public function sendVerificationOtp($to);

    /**
     * Verify Otp
     *
     * @param  mixed $phoneNumber
     * @param  mixed $verificationCode
     * @return
     */
    public function verifyOtp($phoneNumber, $verificationCode);
}