<?php

namespace App\DTOs\Details;

use App\DTOs\Details\Userable\UserableDetailInterface;

class UserDetailDTO implements DTODetail
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public ?string $password = null,
        public ?int $roleId = -1,
        public ?UserableDetailInterface $userable = null
    ) {}
}
