<?php

namespace App\Exceptions\User;

use Exception;

class UserNotDeletedException extends Exception
{
    protected $message = "El usuario no se pudo eliminar";
}
