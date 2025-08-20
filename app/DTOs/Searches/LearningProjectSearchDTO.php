<?php

namespace App\DTOs\Searches;

class LearningProjectSearchDTO implements DTOSearch
{
    private $ticket_ids = [];

    public function __construct(
        public ?int $id = null,
        public ?string $title = null,
        public ?string $content = null,
        public ?int $teacher_id = null,
        public ?int $enrollment_id = null,
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
