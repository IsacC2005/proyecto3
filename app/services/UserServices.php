<?php

namespace App\services;

use App\Constants\RoleConstants;
use App\DTOs\TeacherDTO;
use App\DTOs\Summary\UserDTO;
use App\Repositories\interfaces\UserInterface;
use Spatie\Permission\Models\Role;

class UserServices
{

    public function __construct(
        private UserInterface $userRepository,
    ) {}

    public function createUser(UserDTO $user)
    {
        $this->userRepository->create($user);
    }

    public function allRoles(): array
    {

        return $this->userRepository->allRole();
    }
}
