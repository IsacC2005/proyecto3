<?php

namespace App\Exceptions\LearningProject;

use Exception;

class LearningProjectNotCreatedException extends Exception
{
    protected $message = "El proyecto de aprendizaje no se creo";
}
