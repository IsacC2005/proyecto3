<?php

namespace App\DTOs\Details;

use App\DTOs\Details\Userable\UserableDetailInterface;

class UserDetailDTO implements DTODetail
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public array $roles,
        public ?string $password = null,
        public ?UserableDetailInterface $userable = null
    ) {}
}
