<?php

namespace App\DTOs\Userable;

use App\DTOs\UserDTO;

trait UserableTrait
{
    public ?int $user_id = null;
    private ?UserDTO $user = null;
}

?>