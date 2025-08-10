<?php

namespace App\Exceptions\Ticket;

use Exception;

class TicketNotUpdateException extends Exception
{
    protected $message = "La boleta no se actualizo";
}
