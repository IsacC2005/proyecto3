<?php 

namespace App\Repositories\Interfaces;

use App\DTOs\Summary\UserDTO;

interface UserInterface
{
    public function createUser(UserDTO $user): UserDTO;
    public function findUserById($id): UserDTO;
    public function findAllUser(): array;
    public function findUserByEmail($email): UserDTO;
    public function findUserByRole($role): array;
    public function updateUser(UserDTO $user): UserDTO;
    public function deleteUser($id): void;
}

?>