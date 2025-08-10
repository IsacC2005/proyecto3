<?php

namespace App\Exceptions\Ticket;

use Exception;

class TicketNotFindException extends Exception
{
    protected $message = "La boleta no se encontro";
}
