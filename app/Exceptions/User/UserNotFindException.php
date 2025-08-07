<?php

namespace App\Exceptions\User;

use Exception;

class UserNotFindException extends Exception
{
    protected $message = "Usuario no encontrado";
}
