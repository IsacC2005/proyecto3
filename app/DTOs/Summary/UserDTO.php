<?php

namespace App\DTOs\Summary;

use App\DTOs\Summary\Userable\UserableInterface;

class UserDTO implements DTOSummary
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public ?string $password = null,
        public ?array $roles = [],
        public ?int $roleId = -1,
        public ?int $userable_id = -1,
        public ?UserableInterface $userable = null
    ) {}
}
