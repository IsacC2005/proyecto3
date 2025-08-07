<?php

namespace App\Exceptions\Enrollment;

use Exception;

class EnrollmentNotUpdateException extends Exception
{
    protected $message = "Matricula no actualizada";
}
