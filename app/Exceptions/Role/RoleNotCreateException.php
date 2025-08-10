<?php

namespace App\Exceptions\Role;

use Exception;

class RoleNotCreateException extends Exception
{
    protected $message = "El rol no se creo";
}
