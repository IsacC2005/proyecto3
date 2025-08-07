<?php

namespace App\Exceptions\Teacher;

use Exception;

class TeacherNotUpdateException extends Exception
{
    protected $message = "Profesor no actualizado";
}
