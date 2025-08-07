<?php

namespace App\Exceptions\User;

use Exception;

class UserNotUpdateException extends Exception
{
    protected $message = "El usuario no se actualizo";
}
