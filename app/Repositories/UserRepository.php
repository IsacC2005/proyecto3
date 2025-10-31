<?php

namespace App\Repositories;

use App\Constants\TDTO;
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
use App\Repositories\Interfaces\UserInterface;
use App\Repositories\TransformDTOs\TransformDTOs;
use Spatie\Permission\Models\Role;
use App\DTOs\Summary\DTOSummary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\DTOs\Details\DTODetail;
use App\DTOs\Details\UserDetailDTO;
use App\DTOs\PaginationDTO;
use App\DTOs\Searches\DTOSearch;
use Illuminate\Support\Facades\DB;

class UserRepository extends TransformDTOs implements UserInterface
{

    public function createUser(UserDTO $user): UserDTO
    {
        $model = null;
        DB::transaction(function () use ($user, &$model) {
            $existingUser = User::where('email', $user->email)->first();
            if ($existingUser) {
                throw new EmailDuplicateException();
            }
            $model = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'password' => bcrypt($user->password)
            ]);

            $role = Role::find($user->roleId);

            if (!$role) {
                throw new RoleNotExistException();
            }
            $model->assignRole($role);
        });
        return $model ? $this->transformToDTO($model) : null;
    }



    public function findUserById(int $id, ?string $fn = TDTO::SUMMARY): UserDTO
    {
        try {
            $user = User::find($id);
            if (!$user) {
                throw new UserNotFindException();
            }
            return $this->$fn($user);
        } catch (\Exception $e) {
            throw new UserNotCreatedException();
        }
    }



    public function findUserByUserable(int $id): UserDTO
    {
        try {
            $user = User::where('userable_id', $id)->first();
            if (!$user) {
                throw new UserNotFindException();
            }
            return $this->transformToDTO($user);
        } catch (\Exception $e) {
            //throw $e;
            throw new UserNotFindException();
        }
    }



    public function findAllUser(): PaginationDTO
    {
        try {
            $users = User::with('roles')->paginate(10);
            if ($users->isEmpty()) {
                throw new UserNotFindException();
            }
            $pagination = new PaginationDTO($users);

            $userData = $this->transformListDTO($users->getCollection());

            $pagination->data = $userData;

            return $pagination;
        } catch (\Throwable $th) {
            throw new UserNotFindException($th->getMessage());
        }
    }



    public function findUserByEmail($email): UserDTO
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



    public function findUserByRole($role): array
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



    public function updateUser(UserDetailDTO $user): UserDTO
    {


        try {
            $userModel = User::find($user->id);
            if (!$userModel) {
                throw new UserNotUpdateException();
            }

            $userModel->name = $user->name;
            $userModel->email = $user->email;
            $userModel->save();

            $userModel->syncRoles($user->roles);

            $this->destorySecion($userModel->id);

            return $this->transformToDTO($userModel);
        } catch (\Throwable $th) {
            throw new UserNotUpdateException($th->getMessage());
        }
    }


    public function resetPaswordUser(string $password, int $id): void
    {
        $userModel = User::find($id);

        $userModel->password = bcrypt($password);

        $userModel->save();

        $this->destorySecion($id);
    }



    public function deleteUser($id): void
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


    public function destorySecion($id)
    {
        if (config('session.driver') === 'database') {
            DB::table('sessions')
                ->where('user_id', $id)
                ->delete();
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
            roles: $model->roles->pluck('id')->toArray(),
            //password: $model->password,
            //userable: $user->userable // Assuming userable is a Userable type
        );
    }

    /**
     * @param User $user
     */

    protected function transformToDetailDTO(Model $user): UserDetailDTO
    {

        $roles = $user->roles->pluck('id')->toArray();



        return new UserDetailDTO(
            id: $user->id,
            name: $user->name,
            email: $user->email,
            roles: $roles
            //password: $model->password,
            //userable: $user->userable // Assuming userable is a Userable type
        );
    }
}
