<?php

namespace App\Exceptions\Enrollment;

use Exception;

class EnrollmentNotCreatedException extends Exception
{
    protected $message = "Matricula no creada";
}
