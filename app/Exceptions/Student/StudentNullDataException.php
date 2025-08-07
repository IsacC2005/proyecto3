<?php

namespace App\Exceptions;

use Exception;

class StudentNullDataException extends Exception
{
    protected $message = "Datos errados";
}
