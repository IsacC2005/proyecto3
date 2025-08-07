<?php

namespace App\Exceptions\Representative;

use Exception;

class RepresentativeNotUpdateException extends Exception
{
    protected $message = "Representante no actualizado";
}
