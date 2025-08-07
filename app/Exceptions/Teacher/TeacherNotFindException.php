<?php

namespace App\Exceptions\Teacher;

use Exception;

class TeacherNotFindException extends Exception
{
    protected $message = "Profesor no encontrado";
}
