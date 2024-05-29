<?php

namespace App\Traits;

trait AuthHelperTrait
{
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

    public function cryptPassword($password): string
    {
        return bcrypt($password);
    }
}
