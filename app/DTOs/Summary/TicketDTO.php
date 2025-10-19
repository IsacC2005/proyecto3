<?php


namespace App\DTOs\Summary;

class TicketDTO implements DTOSummary
{
    public function __construct(
        public int $id,
        public string $average,
        public string $content,
        public string $suggestions,
        public string $studentName,
        public string $studentSurName,
        public ?int $learningProjectId = 0,
        public ?int $studentId = 0
    ) {}
}
