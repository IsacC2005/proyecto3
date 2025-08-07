<?php

namespace App\Exceptions\DailyClass;

use Exception;

class DailyClassNotExistException extends Exception
{
    protected $message = "Esta clase diaria no existe";
}
