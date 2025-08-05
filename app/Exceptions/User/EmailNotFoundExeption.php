<?php

namespace App\Exceptions;

use Exception;

class EmailNotFoundExeption extends Exception
{
    protected $message = "El formato del correo no es correto";
}
