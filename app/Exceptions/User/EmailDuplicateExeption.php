<?php

namespace App\Exceptions;

use Exception;

class EmailDuplicateExeption extends Exception
{
    protected $message = "El correo ya existe";
}
