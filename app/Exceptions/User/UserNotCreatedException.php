<?php

namespace App\Exceptions\User;

use Exception;

class UserNotCreatedException extends Exception
{
    protected $message = "El usario no se creo";
}
