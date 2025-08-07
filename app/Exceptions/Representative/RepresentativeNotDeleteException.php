<?php

namespace App\Exceptions\Representative;

use Exception;

class RepresentativeNotDeleteException extends Exception
{
    protected $message = "EL representante no existe";
}
