<?php

namespace App\Exceptions;

use Exception;

class StudentNotCreatedException extends Exception
{
    protected $message = "Estudiante no creado";
}
