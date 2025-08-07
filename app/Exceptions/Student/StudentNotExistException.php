<?php

namespace App\Exceptions\Student;

use Exception;

class StudentNotExistException extends Exception
{
    protected $message = "El estudiante no existe";
}
