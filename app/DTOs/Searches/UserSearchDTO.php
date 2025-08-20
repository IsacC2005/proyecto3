<?php

namespace App\DTOs\Searches;

use App\DTOs\Searches\Userable\UserableSearchInterface;

class UserSearchDTO implements DTOSearch
{
    public function __construct(
        public ?int $id = null,
        public ?string $name = null,
        public ?string $email = null,
        public ?string $password = null,
        public ?int $rol_id = null,
        public ?UserableSearchInterface $userable = null
    ) {}
}
?>
