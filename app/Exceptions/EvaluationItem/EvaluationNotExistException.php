<?php

namespace App\Exceptions\EvaluationItem;

use Exception;

class EvaluationNotExistException extends Exception
{
    protected $message = 'No existe este Item de evaluacion';
}
