<?php

namespace App\DTOs;

use App\DTOs\UserableAbstract\Userable;

class UserDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public string $password,
        public ?int $rol_id = -1,
        public ?Userable $userable = null
    ) {}
}
?>