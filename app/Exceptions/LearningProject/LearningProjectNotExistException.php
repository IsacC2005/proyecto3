<?php

namespace App\Exceptions\LearningProject;

use Exception;

class LearningProjectNotExistException extends Exception
{
    protected $message = "El proyecto de aprendizaje no existe";
}
