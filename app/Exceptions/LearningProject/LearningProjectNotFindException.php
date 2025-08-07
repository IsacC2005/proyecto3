<?php

namespace App\Exceptions\LearningProject;

use Exception;

class LearningProjectNotFindException extends Exception
{
    protected $message = "Proyecto de aprendizaje no encontrado";
}
