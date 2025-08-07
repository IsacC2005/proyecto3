<?php

namespace App\Exceptions\User;

use Exception;

class UserNotExistException extends Exception
{
    protected $message = "El usuario no existe";
}
