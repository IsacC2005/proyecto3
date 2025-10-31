<?php

namespace App\Repositories\Interfaces;

use App\Constants\TDTO;
use App\DTOs\Details\UserDetailDTO;
use App\DTOs\PaginationDTO;
use App\DTOs\Summary\UserDTO;

interface UserInterface
{
    public function createUser(UserDTO $user): UserDTO | null;

    public function findUserById(int $id, ?string $fn = TDTO::SUMMARY): UserDTO;

    public function findAllUser(): PaginationDTO;

    public function findUserByUserable(int $id): UserDTO;

    public function findUserByEmail(string $email): UserDTO;

    public function findUserByRole(string $role): array;

    public function updateUser(UserDetailDTO $user): UserDTO;

    public function resetPaswordUser(string $password, int $id): void;

    public function deleteUser(int $id): void;
}
