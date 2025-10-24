<?php

namespace App\Services;


use App\DTOs\Summary\UserDTO;
use App\Repositories\Interfaces\UserInterface;

class UserServices
{

    public function __construct(
        private UserInterface $userRepository,
    ) {}



    public function createUser(UserDTO $user): UserDTO
    {
        return $this->userRepository->createUser($user);
    }



    public function findByUserById(int $id): UserDTO
    {
        return $this->userRepository->findUserById($id);
    }



    public function findByUserByUserable(int $id): UserDTO
    {
        return $this->userRepository->findUserByUserable($id);
    }



    public function findAllUser(): array
    {
        return $this->userRepository->findAllUser();
    }



    public function findUserByEmail(string $email): UserDTO
    {
        return $this->userRepository->findUserByEmail($email);
    }



    public function findUserByRole(string $role): array
    {
        return $this->userRepository->findUserByRole($role);
    }



    public function updateUser(UserDTO $user): UserDTO
    {
        return $this->userRepository->updateUser($user);
    }



    public function deleteUser(int $id): void
    {
        $this->userRepository->deleteUser($id);
    }
}
