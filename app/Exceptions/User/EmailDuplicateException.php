<?php

namespace App\Exceptions\User;

use Exception;

class EmailDuplicateException extends Exception
{
    protected $message = "El correo ya existe";
}
