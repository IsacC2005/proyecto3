<?php

namespace App\DTOs\UserableAbstract;

use App\DTOs\UserDTO;

abstract class Userable
{
    public int $id;
    public string $name;
    public string $surname;
    public ?UserDTO $user = null;
}
?>