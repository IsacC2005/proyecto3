<?php

namespace App\Exceptions\Teacher;

use Exception;

class TeacherNotDeleteException extends Exception
{
    protected $message = "Profesor no eliminado";
}
