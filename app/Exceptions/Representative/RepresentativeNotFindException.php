<?php

namespace App\Exceptions\Representative;

use Exception;

class RepresentativeNotFindException extends Exception
{
    protected $message = "Representante no encontrado";
}
