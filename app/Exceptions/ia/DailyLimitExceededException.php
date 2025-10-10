<?php

namespace App\Exceptions\ia;

use Exception;

class DailyLimitExceededException extends Exception
{
    protected $retryAfter;

    public function __construct(string $message = "Límite de uso diario de la IA alcanzado. Reintentando mañana.", int $code = 429, ?\Throwable $previous = null)
    {
        // Calcula los segundos restantes hasta la medianoche + 1 minuto de buffer
        $midnight = now()->addDay()->startOfDay();
        $this->retryAfter = now()->diffInSeconds($midnight) + 60;

        parent::__construct($message, $code, $previous);
    }

    /**
     * Devuelve el tiempo de espera en segundos para el reintento de la cola.
     */
    public function getRetryAfter(): int
    {
        return $this->retryAfter;
    }
}
