<?php 

namespace App\Repositories\interfaces;

use App\DTOs\UserDTO;

interface UserInterface
{
    public function allRole(): array;
    public function create(UserDTO $user): bool;
    public function find($id): UserDTO | null;
    public function findAll(): array;
    public function findByEmail($email): UserDTO | null;
    public function findByRole($role): array;
    public function update(UserDTO $user): UserDTO | null;
    public function delete($id): void;
}

?>