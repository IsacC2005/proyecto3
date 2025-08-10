<?php

namespace App\DTOs\Summary;

use App\DTOs\Summary\Userable\UserableInterface;

class UserDTO implements DTOSummary
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public string $password,
        public ?int $rol_id = -1,
        public ?UserableInterface $userable = null
    ) {}
}
?>