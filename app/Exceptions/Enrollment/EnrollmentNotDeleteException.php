<?php

namespace App\Exceptions\Enrollment;

use Exception;

class EnrollmentNotDeleteException extends Exception
{
    protected $message = "Matricula no eliminada";
}
