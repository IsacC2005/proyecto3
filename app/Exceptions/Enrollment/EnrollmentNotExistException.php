<?php

namespace App\Exceptions\Enrollment;

use Exception;

class EnrollmentNotExistException extends Exception
{
    protected $message = "La matricual no existe";
}
