<?php

namespace App\Exceptions\LearningProject;

use Exception;

class LearningProjectNotUpdateException extends Exception
{
    protected $message = "Proyecto de aprendizaje no actualizado";
}
