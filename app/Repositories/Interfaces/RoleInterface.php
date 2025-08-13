<?php

namespace App\Repositories\Interfaces;

use App\DTOs\Summary\RoleDTO;

interface RoleInterface {

    public function createRole(RoleDTO $role): RoleDTO;
    public function findRoleById(int $id): RoleDTO;
    public function allRole(): array;
    public function findRoleByPermission(String... $permission): array;
    public function existRoleWithName(String $name): bool;
    public function updateRole(RoleDTO $role): RoleDTO;
    public function deleteRole(int $id): void;

}