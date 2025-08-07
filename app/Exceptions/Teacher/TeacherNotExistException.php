<?php

namespace App\Exceptions\Teacher;

use Exception;

class TeacherNotExistException extends Exception
{
    protected $message = "El profesor no existe";
}
