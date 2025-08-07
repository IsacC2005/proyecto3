<?php

namespace App\Exceptions\Role;

use Exception;

class RoleNotExistException extends Exception
{
    protected $message = "El rol no existe";
}
