<?php

namespace App\Exceptions\Student;

use Exception;

class StudentNotFindInTheEnrollmentException extends Exception
{
    protected $message = "No se encontro ningun estudiante en esta matricula";
}
