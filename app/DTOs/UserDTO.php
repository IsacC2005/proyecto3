<?php

namespace App\DTOs;

use App\DTOs\UserableAbstract\Userable;

class UserDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public Userable $userable
    ) {}
}
?>