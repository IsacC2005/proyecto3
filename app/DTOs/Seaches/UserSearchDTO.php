<?php

namespace App\DTOs\Searches;

use App\DTOs\Userable\UserableInterface;

class UserSearchDTO
{
    public function __construct(
        public ?int $id = null,
        public ?string $name = null,
        public ?string $email = null,
        public ?string $password = null,
        public ?int $rol_id = null,
        public ?UserableInterface $userable = null
    ) {}
}
?>