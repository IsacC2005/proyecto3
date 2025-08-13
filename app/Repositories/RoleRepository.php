<?php

namespace App\Repositories;

use App\Repositories\Interfaces\RoleInterface;
use App\DTOs\Summary\RoleDTO;
use App\Exceptions\Role\RoleNotCreateException;
use App\Repositories\TransformDTOs\TransformDTOs;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\DTOs\Summary\DTOSummary;
use App\Exceptions\Permission\PermissionNotExistException;
use App\Exceptions\Role\RoleNotExistException;
use App\Exceptions\Role\RoleNotFindException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class RoleRepository extends TransformDTOs implements RoleInterface
{

    public function createRole(RoleDTO $role): RoleDTO
    {
        try {
            $roleModel = Role::create([
                'name' => $role->name
            ]);

            if (!$roleModel) {
                throw new RoleNotCreateException();
            }
            return $this->transformToDTO($roleModel);
        } catch (\Throwable $th) {
            throw new RoleNotCreateException();
        }
    }



    public function findRoleById(int $id): RoleDTO
    {
        try {
            $roleModel = Role::find($id);

            if (!$roleModel) {
                throw new RoleNotFindException();
            }
            return $this->transformToDTO($roleModel);
        } catch (\Throwable $th) {
            throw new RoleNotFindException();
        }
    }



    public function allRole(): array
    {
        try {
            $roleModel = Role::all();

            if (!$roleModel) {
                throw new RoleNotFindException();
            }

            return $this->transformListDTO($roleModel);
        } catch (\Throwable $th) {
            throw new RoleNotFindException();
        }
    }



    public function findRoleByPermission(String ...$permission): array
    {
        try {
            $permissionModels = Permission::whereIn('name', $permission)->get();

            if ($permissionModels->isEmpty()) {
                throw new PermissionNotExistException();
            }

            $roleModel = $permissionModels->flatMap(function ($permissionModel) {
                return $permissionModel->roles;
            })->unique();

            return $this->transformListDTO($roleModel);
        } catch (\Throwable $th) {
            throw new RoleNotFindException("No se encontraron roles para los permisos dados.", 0, $th);
        }
    }



    public function updateRole(RoleDTO $role): RoleDTO
    {
        $roleModel = Role::find($role->id);
        if (!$roleModel) {
            throw new RoleNotExistException();
        }

        $roleModel->name = $role->name;

        $permissionModels = Permission::whereIn('id', $role->getPermisions())->get();

        if ($permissionModels->isNotEmpty()) {
            $roleModel->syncPermissions($permissionModels);
        }

        $roleModel->save();

        return $this->transformToDTO($roleModel);
    }



    public function deleteRole(int $id): void
    {
        $roleModel = Role::find($id);

        if(!$roleModel){
            throw new RoleNotExistException();
        }

        $roleModel->delete();
    }



    public function existRoleWithName(string $name): bool
    {
        return Role::where('name', $name)->exists();
    }



    protected function transformToDTO(Model $model): DTOSummary
    {
        $permissions = $model->permissions()->pluck('permission_id')->toArray();
        $roleDTO = new RoleDTO(
            id: $model->id,
            name: $model->name,
        );

        $roleDTO->addPermision($permissions);

        return $roleDTO;
    }
}
