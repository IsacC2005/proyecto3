<?php

namespace App\Exceptions\Student;

use Exception;

class StudentNotUpdateException extends Exception
{
    protected $message = "Estudiante no actualizado";
}
