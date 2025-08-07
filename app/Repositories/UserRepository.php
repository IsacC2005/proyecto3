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
use App\DTOs\UserDTO;
use App\Models\User;
use App\Repositories\interfaces\UserInterface;
use App\Repositories\traits\UserTrait;
use Doctrine\Inflector\Rules\Transformation;
use Spatie\Permission\Models\Role;

class UserRepository implements UserInterface
{

    use UserTrait;

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
            if(!$role){
                throw new RoleNotExistException();
            }
            $userModel->assingRole($role);
            return $this->transformToDTO($userModel);
        } catch (\Exception $e) {
            throw new UserNotCreatedException();
        }
    }



    public function find($id): UserDTO
    {
        try {
            $user = User::find($id);
            if (!$user) {
                throw new UserNotFindException();
            }
            return new UserDTO(
                id: $user->id,
                name: $user->name,
                email: $user->email,
                password: $user->password
            );
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
            return $this->transformListDTO($users->toArray());
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
            return $this->transformListDTO($users->toArray());
        } catch (\Throwable $th) {
            throw new UserNotFindException();
        }
    }



    public function update(UserDTO $user): UserDTO
    {
        try {
            $existingUser = User::find($user->id);
            if (!$existingUser) {
                throw new UserNotUpdateException();
            }

            $existingUser->name = $user->name;
            $existingUser->email = $user->email;
            $existingUser->password = bcrypt($user->password);
            $existingUser->save();

            return new UserDTO(
                id: $existingUser->id,
                name: $existingUser->name,
                email: $existingUser->email,
                password: $existingUser->password,
            );
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
}
