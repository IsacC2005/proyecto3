<?php

namespace App\Exceptions\LearningProject;

use Exception;

class LearningProjectNotDeleteException extends Exception
{
    protected $message = "Proyecto de aprendizaje no eliminado";
}
