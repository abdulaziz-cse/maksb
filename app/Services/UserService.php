<?php
namespace App\Services;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redis;
use Illuminate\Validation\ValidationException;

class UserService
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getProfile(int $userId): User
    {
        $user = $this->userRepository->getOne($userId);


        if (! $user) {
            abort(404, 'User not found');
        }

        $user->load('photo');

        return $user;
    }


    public function create(array $data): User
    {
        // Create user
        $user = $this->userRepository->create($data);

        // Assign user role
        $user->assignRole('consumer');

        return $user;
    }

    public function updateProfile(int $userId,array $data): User
    {
        $user = $this->userRepository->getOne($userId);
        if (! $user) {
            abort(404, 'User not found');
        }

        $oldPhone = $user->phone;
        $oldEmail = $user->email;
        if (isset($data['phone']) && $data['phone'] !== $oldPhone) {
            $isPhoneVerified = (bool) Redis::get('user_'.$user->id.'_verified_'.$data['phone']);
            if (! $isPhoneVerified) {
                abort(400, 'Phone not verified.');
            }
        }

        // Update user profile
        $user = $this->userRepository->update($user->id, Arr::except($data, ['password']));

        if (isset($data['email']) && $data['email'] !== $oldEmail) {
            // Send verification code
            $user->email_verified_at = null;
        }

        $user->save();


        $this->updatePassword($user, $data);

        $this->updatePhoto($user, $data);

        $user->load('photo');

        return $user;


    }

    public function updatePhoto(User $user, array $data): User
    {
        if (isset($data['photo']) && $data['photo'] instanceof UploadedFile) {
            $user->addMedia($data['photo'])->toMediaCollection('avatars');
        } elseif (array_key_exists('photo', $data) && empty($data['photo'])) {
            // Delete all user media
            // As there is only one collection - avatars
            $user->media()->delete();
        }

        return $user;
    }

    public function updatePassword(User $user, array $data): User
    {
        $currentUser = auth()->user();

        if (! isset($data['password'], $currentUser)) {
            return $user;
        }

        if (! isset($data['oldpassword'])) {
            $message = $currentUser->isAdmin() ?
                'Your admin password is incorrect' :
                'Please provide old password';

            throw ValidationException::withMessages([
                'oldpassword' => $message,
            ]);
        }

        // Check for old password or admin password for admins
        if ( ! \Hash::check($data['oldpassword'], $currentUser->password)) {
            $message = $currentUser->isAdmin() ?
                'Your admin password is incorrect' :
                'Old password is incorrect';

            throw ValidationException::withMessages([
                'oldpassword' => $message,
            ]);
        }

        $user->update(['password' => $data['password']]);

        return $user;
    }

}
