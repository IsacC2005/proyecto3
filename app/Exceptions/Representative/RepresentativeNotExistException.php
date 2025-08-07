<?php

namespace App\Exceptions\Representative;

use Exception;

class RepresentativeNotExistException extends Exception
{
    protected $message = "El representante no existe";
}
