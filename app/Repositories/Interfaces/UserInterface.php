<?php

namespace App\Repositories\Interfaces;

use App\DTOs\Summary\UserDTO;

interface UserInterface
{
    public function createUser(UserDTO $user): UserDTO;

    public function findUserById(int $id): UserDTO;

    public function findAllUser(): array;

    public function findUserByUserable(int $id): UserDTO;

    public function findUserByEmail(string $email): UserDTO;

    public function findUserByRole(string $role): array;

    public function updateUser(UserDTO $user): UserDTO;

    public function deleteUser(int $id): void;
}
