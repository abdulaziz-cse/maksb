<?php
namespace App\Services;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;

class UserService
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create(array $data): User
    {
        // Create user
        $user = $this->userRepository->create($data);

        // Assign user role
//        $user->assignRole('customer');

        return $user;
    }

}
