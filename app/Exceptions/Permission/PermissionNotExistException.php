<?php

namespace App\Exceptions\Permission;

use Exception;

class PermissionNotExistException extends Exception
{
    protected $message = "El permiso no existe";
}
