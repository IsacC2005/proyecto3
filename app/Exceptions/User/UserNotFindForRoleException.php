<?php

namespace App\Exceptions\User;

use Exception;

class UserNotFindForRoleException extends Exception
{
    protected $message = "No se encontro ningun usuario con ese rol";
}
