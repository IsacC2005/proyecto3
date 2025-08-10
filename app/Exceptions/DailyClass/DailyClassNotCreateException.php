<?php

namespace App\Exceptions\DailyClass;

use Exception;

class DailyClassNotCreateException extends Exception
{
    protected $message = "La clase diaria no se creo";
}
