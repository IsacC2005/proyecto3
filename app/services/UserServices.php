<?php

namespace App\services;

use App\DTOs\UserDTO;
use App\Repositories\interfaces\UserInterface;


class UserServices {

    public function __construct(
        private UserInterface $userRepository
    ){}

    public function createUser(UserDTO $user): bool
    {
        return $this->userRepository->create($user);
    }

    public function allRoles(): array {
        
        return $this->userRepository->allRole();
    }
}

?>