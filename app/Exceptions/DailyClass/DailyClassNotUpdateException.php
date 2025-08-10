<?php

namespace App\Exceptions\DailyClass;

use Exception;

class DailyClassNotUpdateException extends Exception
{
    protected $message = "Clase diaria no actualizada";
}
