<?php

namespace App\Services\V2\User;

use Illuminate\Support\Arr;
use App\Models\V2\User\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Redis;
use App\Validators\Auth\UserValidator;
use Illuminate\Validation\ValidationException;
use App\Contracts\Repositories\UserRepositoryInterface;

class UserService
{
    // private $userRepository;

    // public function __construct(UserRepositoryInterface $userRepository, private $user)
    // {
    //     $this->userRepository = $userRepository;
    // }

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

    // public function create(array $data): User
    // {
    //     // Create user
    //     $user = $this->userRepository->create($data);

    //     // Assign user role
    //     $user->assignRole('consumer');

    //     return $user;
    // }

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


        // $this->updatePassword($user, $data);

        // $this->updatePhoto($user, $data);

        // $user->load('photo');

        return $user;
    }

    // public function updatePhoto(User $user, array $data): User
    // {
    //     if (isset($data['photo']) && $data['photo'] instanceof UploadedFile) {
    //         $user->addMedia($data['photo'])->toMediaCollection('avatars');
    //     } elseif (array_key_exists('photo', $data) && empty($data['photo'])) {
    //         // Delete all user media
    //         // As there is only one collection - avatars
    //         $user->media()->delete();
    //     }

    //     return $user;
    // }

    // public function updatePassword(User $user, array $data): User
    // {
    //     $currentUser = auth()->user();

    //     if (!isset($data['password'], $currentUser)) {
    //         return $user;
    //     }

    //     if (!isset($data['oldpassword'])) {
    //         $message = $currentUser->isAdmin() ?
    //             'Your admin password is incorrect' :
    //             'Please provide old password';

    //         throw ValidationException::withMessages([
    //             'oldpassword' => $message,
    //         ]);
    //     }

    //     // Check for old password or admin password for admins
    //     if (!\Hash::check($data['oldpassword'], $currentUser->password)) {
    //         $message = $currentUser->isAdmin() ?
    //             'Your admin password is incorrect' :
    //             'Old password is incorrect';

    //         throw ValidationException::withMessages([
    //             'oldpassword' => $message,
    //         ]);
    //     }

    //     $user->update(['password' => $data['password']]);

    //     return $user;
    // }







}
