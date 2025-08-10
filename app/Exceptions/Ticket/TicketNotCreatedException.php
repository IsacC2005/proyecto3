<?php

namespace App\Exceptions\Ticket;

use Exception;

class TicketNotCreatedException extends Exception
{
    protected $message = "La boleta no se creo";
}
