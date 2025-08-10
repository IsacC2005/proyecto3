<?php

namespace App\Exceptions\Ticket;

use Exception;

class TicketNotExistException extends Exception
{
    protected $message = "La boleta no existe";
}
