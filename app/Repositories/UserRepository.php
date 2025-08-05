<?php

namespace App\Repositories;

use App\Constants\RoleConstants;
use App\DTOs\UserDTO;
use App\Models\User;
use App\Repositories\interfaces\UserInterface;
use App\Repositories\traits\UserTrait;
use Spatie\Permission\Models\Role;

class UserRepository implements UserInterface
{

    use UserTrait;

    public function allRole(): array {
        $roleModel = Role::all(['id', 'name']);
        return $roleModel->toArray();
    }

    public function create(UserDTO $user): bool
    {
        try {
            $existingUser = User::where('email', $user->email)->first();
            if ($existingUser) {
                throw new \Exception("User with this email already exists.");
            }
            $userModel = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'password' => bcrypt($user->password),
            ]);
            $userModel->assingRole($user->rol_id);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }



    public function find($id): UserDTO | null
    {
        $user = User::find($id);
        if (!$user) {
            return null;
        }
        return new UserDTO(
            id: $user->id,
            name: $user->name,
            email: $user->email,
            password: $user->password
        );
    }



    public function findAll(): array
    {
        $users = User::all();

        if ($users->isEmpty()) {
            return [];
        }

        return $this->transformListDTO($users->toArray());
    }



    public function findByEmail($email): UserDTO | null
    {
        $user = User::where('email', $email)->first();
        if (!$user) {
            return null;
        }
        return $this->transformToDTO($user);
    }



    public function findByRole($role): array
    {
        $users = User::role($role)->get();
        if ($users->isEmpty()) {
            return [];
        }

        return $this->transformListDTO($users->toArray());
    }



    public function update(UserDTO $user): UserDTO | null
    {
        $existingUser = User::find($user->id);
        if (!$existingUser) {
            return null;
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
    }
        

    public function delete($id): void
    {
        $user = User::find($id);
        if (!$user) {
            throw new \Exception("User not found.");
            return;
        }
        $user->delete();
    }
}
