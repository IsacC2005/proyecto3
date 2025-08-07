<?php

namespace App\Exceptions\Enrollment;

use Exception;

class EnrollmentNotFindException extends Exception
{
    protected $message = "Matricula no encontrada";
}
