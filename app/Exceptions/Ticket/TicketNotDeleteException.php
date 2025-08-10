<?php

namespace App\Exceptions\Ticket;

use Exception;

class TicketNotDeleteException extends Exception
{
    protected $message = "La boleta no se elimino";
}
