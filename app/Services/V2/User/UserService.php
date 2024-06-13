<?php

namespace App\Services\V2\User;

use App\Traits\MediaTrait;
use App\Models\V2\User\User;
use App\Traits\AuthHelperTrait;
use App\Validators\Auth\UserValidator;

class UserService
{
    use MediaTrait, AuthHelperTrait;

    public function createOne(array $userData): User
    {
        return User::create($userData)->fresh();
    }

    public function getOneByPhone($phone)
    {
        return User::where('phone', $phone)->first();
    }

    public function updateOne(array $userData, User $user): User
    {
        return tap($user)->update($userData);
    }

    public function deleteOne(User $user): bool
    {
        return $user->delete();
    }

    public function updateProfile(array $userData, User $user): User
    {
        UserValidator::throwExceptionIfPhoneNotVerified($user);

        $oldPhone = $user?->phone;
        $oldEmail = $user?->email;

        $user = $this->updateOne($userData, $user);

        if (isset($userData['phone']) && $userData['phone'] !== $oldPhone)
            $user->phone_verified_at = null;

        if (isset($userData['email']) && $userData['email'] !== $oldEmail)
            $user->email_verified_at = null;

        $user->save();

        return $user;
    }

    public function updatePhoto(array $userData)
    {
        $user =  auth()->user();
        $collectionName = 'avatars';

        if (!empty($userData['photo']))
            $this->uploadImage($user, $userData['photo'], $collectionName);
        else
            $this->deleteImage($user);

        return $user;
    }

    public function updatePassword(array $userData): User
    {
        $currentUser = auth()->user();
        $oldPassword = $userData['old_password'] ?? null;

        UserValidator::throwExceptionIfPhoneNotVerified($currentUser);
        UserValidator::throwExceptionIfPasswordIsnotMatch($currentUser, $oldPassword);

        if (!empty($userData['new_password'])) {
            $userData = ['password' => $this->cryptPassword($userData['new_password'])];
            $user = $this->updateOne($userData, $currentUser);
        }

        return $user;
    }
}
