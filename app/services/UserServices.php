<?php

namespace App\services;

use App\Constants\RoleConstants;
use App\DTOs\TeacherDTO;
use App\DTOs\UserDTO;
use App\Repositories\interfaces\UserInterface;
use Spatie\Permission\Models\Role;

class UserServices
{

    public function __construct(
        private UserInterface $userRepository,
        private ManagerUserableRoleService $managerUserableRole
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
