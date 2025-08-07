<?php

namespace App\Exceptions\User;

use Exception;

class UserNotFindForEmailException extends Exception
{
    protected $message = "No se encontro ningun usuario con ese correo electronico";
}
