<?php

namespace App\Repositories;

use App\Exceptions\Role\RoleNotExistException;
use App\Exceptions\User\EmailDuplicateException;
use App\Exceptions\User\UserNotCreatedException;
use App\Exceptions\User\UserNotDeletedException;
use App\Exceptions\User\UserNotExistException;
use App\Exceptions\User\UserNotFindException;
use App\Exceptions\User\UserNotFindForEmailException;
use App\Exceptions\User\UserNotFindForRoleException;
use App\Exceptions\User\UserNotUpdateException;
use App\DTOs\Summary\UserDTO;
use App\Models\User;
use App\Repositories\interfaces\UserInterface;
use App\Repositories\TransformDTOs\TransformDTOs;
use Spatie\Permission\Models\Role;
use App\DTOs\Summary\DTOSummary;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends TransformDTOs implements UserInterface
{

    public function allRole(): array
    {
        $roleModel = Role::all(['id', 'name']);
        return $roleModel->toArray();
    }



    public function create(UserDTO $user): UserDTO
    {
        try {
            $existingUser = User::where('email', $user->email)->first();
            if ($existingUser) {
                throw new EmailDuplicateException();
            }
            $userModel = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'password' => bcrypt($user->password),
            ]);

            $role = Role::find($user->rol_id);

            if (!$role) {
                throw new RoleNotExistException();
            }
            $userModel->assignRole($role);
            return $this->transformToDTO($userModel);
        } catch (\Exception $e) {
            throw new UserNotCreatedException($e->getMessage());
        }
    }



    public function find($id): UserDTO
    {
        try {
            $user = User::find($id);
            if (!$user) {
                throw new UserNotFindException();
            }
            return $this->transformToDTO($user);
        } catch (\Exception $e) {
            throw new UserNotCreatedException();
        }
    }



    public function findAll(): array
    {
        try {
            $users = User::all();
            if ($users->isEmpty()) {
                throw new UserNotFindException();
            }
            return $this->transformListDTO($users);
        } catch (\Throwable $th) {
            throw new UserNotFindException();
        }
    }



    public function findByEmail($email): UserDTO
    {
        try {
            $user = User::where('email', $email)->first();
            if (!$user) {
                throw new UserNotFindForEmailException();
            }
            return $this->transformToDTO($user);
        } catch (\Throwable $th) {
            throw new UserNotFindException();
        }
    }



    public function findByRole($role): array
    {
        try {
            $users = User::role($role)->get();
            if ($users->isEmpty()) {
                throw new UserNotFindForRoleException();
            }
            return $this->transformListDTO($users);
        } catch (\Throwable $th) {
            throw new UserNotFindException();
        }
    }



    public function update(UserDTO $user): UserDTO
    {
        try {
            $userModel = User::find($user->id);
            if (!$userModel) {
                throw new UserNotUpdateException();
            }

            $userModel->name = $user->name;
            $userModel->email = $user->email;
            $userModel->password = bcrypt($user->password);
            $userModel->save();

            return $this->transformToDTO($userModel);
        } catch (\Throwable $th) {
            throw new UserNotUpdateException();
        }
    }



    public function delete($id): void
    {
        try {
            $user = User::find($id);
            if (!$user) {
                throw new UserNotExistException();
            }
            $user->delete();
        } catch (\Throwable $th) {
            throw new UserNotDeletedException();
        }
    }

    /**
     * 
     * TODO Este método se está redefiniendo polimórficamente.
     * 
     */
    protected function transformToDTO(Model $model): DTOSummary
    {
        return new UserDTO(
            id: $model->id,
            name: $model->name,
            email: $model->email,
            password: $model->password,
            //userable: $user->userable // Assuming userable is a Userable type
        );
    }
}
