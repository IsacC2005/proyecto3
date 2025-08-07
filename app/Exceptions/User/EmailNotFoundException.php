<?php

namespace App\Exceptions\User;

use Exception;

class EmailNotFoundException extends Exception
{
    protected $message = "El formato del correo no es correto";
}
