<?php

namespace App\Exceptions\Student;

use Exception;

class StudentNotFindException extends Exception
{
    protected $message = "Estudiante no encontrado";
}
