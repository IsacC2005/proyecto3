<?php

namespace App\DTOs\UserableAbstract;

use App\DTOs\UserDTO;

abstract class Userable
{
    public ?int $user_id = null;
    private ?UserDTO $user = null;

    public function getUser(): ?UserDTO
    {
        return $this->user;
    }

    public function setUser(?UserDTO $user = null): void
    {
        $this->user = $user;
    }
}
?>