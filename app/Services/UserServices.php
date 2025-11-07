<?php

namespace App\Services;

use App\DTOs\Details\UserDetailDTO;
use App\DTOs\PaginationDTO;
use App\DTOs\Summary\UserDTO;
use App\Repositories\Interfaces\UserInterface;
use App\Utilities\FlashMessage;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserServices
{

    public function __construct(
        private UserInterface $userRepository,
    ) {}



    public function createUser(UserDTO $user)
    {
        $result = $this->userRepository->createUser($user);

        if (!$result) {
            activity('Error al crear usuario')
                ->causedBy(Auth::user())
                ->log('Error al crear usuario: se intento crear un usuario con estos datos: ' . json_encode($user));
            return Inertia::render('Users/CreateUser')->with(
                'flash',
                FlashMessage::error(
                    'Error',
                    'Usuario no creado',
                    'El usuario no se creo'
                )
            );
        }
        return redirect()->route('manager.user.index')->with(
            'flash',
            FlashMessage::success(
                'Exito',
                'Usuario Creado',
                'El usuario se creo sin problemas'
            )
        );
    }



    public function findByUserById(int $id): UserDTO
    {
        return $this->userRepository->findUserById($id);
    }



    public function findByUserByUserable(int $id): UserDTO
    {
        return $this->userRepository->findUserByUserable($id);
    }



    public function findAllUser(): PaginationDTO
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



    public function AdminUpdateUser(UserDetailDTO $user): UserDTO
    {
        return $this->userRepository->updateUser($user);
    }


    public function AdminResetPaswordUser(string $password, int $id): void
    {
        $this->userRepository->resetPaswordUser($password, $id);
    }


    public function deleteUser(int $id): void
    {
        $this->userRepository->deleteUser($id);
    }
}
