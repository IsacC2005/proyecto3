<?php

namespace App\Repositories\Traits;

use App\DTOs\Summary\UserDTO;
use App\Models\User;

trait UserTrait
{
    /**
     * ?Metodos privados para transformar los datos de usuario a DTO
     * 
     * @param array $users
     * @return array<UserDTO>
     */
    private function transformListDTO(array $users): array
    {
        return array_map([$this, 'transformToDTO'], $users);
    }

    private function transformToDTO(User $user): UserDTO
    {
        return new UserDTO(
            id: $user->id,
            name: $user->name,
            email: $user->email,
            password: $user->password,
            //userable: $user->userable // Assuming userable is a Userable type
        );
    }
}

?>