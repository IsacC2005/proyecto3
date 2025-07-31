<?php


namespace App\DTOs;

use App\Models\Enrollment;

class LearningProjectDTO
{
    private $tickets = [];

    public function __construct(
        public int $id,
        public string $title,
        public string $content,
        public ?TeacherDTO $teacher = null,
        public ?DailyClassDTO $daily_class = null,
        public ?EnrollmentDTO $enrollment = null,
    ) {}

    public function addTicket(TicketDTO $ticket): void
    {
        $this->tickets[] = $ticket;
    }

    public function getTickets(): array
    {
        return $this->tickets;
    }
}
