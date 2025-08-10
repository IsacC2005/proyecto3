<?php


namespace App\DTOs\Summary;


class LearningProjectDTO implements DTOSummary
{
    private $ticket_ids = [];

    public function __construct(
        public int $id,
        public string $title,
        public string $content,
        public ?int $teacher_id = 0,
        public ?int $enrollment_id = 0,
//        public ?DailyClassDTO $daily_class = null,
//        public ?EnrollmentDTO $enrollment = null,
    ) {}

    public function addTicket(int $ticket_id): void
    {
        $this->ticket_ids[] = $ticket_id;
    }

    public function getTickets(): array
    {
        return $this->ticket_ids;
    }
}
