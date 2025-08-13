<?php

namespace App\Exceptions\Role;

use Exception;

class RoleNotFindException extends Exception
{
    protected $message = "El rol no se encontro";
}
