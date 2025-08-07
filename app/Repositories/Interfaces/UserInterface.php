<?php 

namespace App\Repositories\interfaces;

use App\DTOs\UserDTO;

interface UserInterface
{
    public function allRole(): array;
    public function create(UserDTO $user): UserDTO;
    public function find($id): UserDTO;
    public function findAll(): array;
    public function findByEmail($email): UserDTO;
    public function findByRole($role): array;
    public function update(UserDTO $user): UserDTO;
    public function delete($id): void;
}

?>