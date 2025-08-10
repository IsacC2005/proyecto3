<?php

namespace App\services;

class RoleService {
    public function allRoles(): array
    {

        return $this->userRepository->allRole();
    }
}