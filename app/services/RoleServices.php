<?php

namespace App\Services;

use App\DTOs\Summary\RoleDTO;
use App\Exceptions\Role\RoleNotCreateException;
use App\Repositories\Interfaces\RoleInterface;

class RoleServices
{

    public function __construct(
        private RoleInterface $roleRepository
    ) {}



    public function createRole(RoleDTO $role)
    {

        if ($this->roleRepository->existRoleWithName($role->name)) {
            throw new RoleNotCreateException("Ya existe un rol con ese nombre", 409);
        }

        $this->roleRepository->createRole($role);
    }



    public function findRole(int $id): RoleDTO 
    {
        return $this->roleRepository->findRoleById($id);
    }


    public function findRoleByName(string $name): RoleDTO 
    {
        return $this->roleRepository->findRoleByName($name);
    }


    public function allRoles(): array
    {
        return $this->roleRepository->allRole();
    }



    public function findRoleByPermission(string... $permission): array
    {
        return $this->roleRepository->findRoleByPermission(...$permission);
    }



    public function updateRole(RoleDTO $role): RoleDTO 
    {
        return $this->roleRepository->updateRole($role);
    }



    public function deleteRole(int $id): void 
    {
        $this->roleRepository->deleteRole($id);
    }
}
