<?php

namespace App\Exceptions\DailyClass;

use Exception;

class DailyClassNotDeleteException extends Exception
{
    protected $message = "La clase diaria no se elimino";
}
