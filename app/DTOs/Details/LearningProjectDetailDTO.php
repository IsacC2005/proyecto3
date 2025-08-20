<?php


namespace App\DTOs\Details;


class LearningProjectDetailDTO implements DTODetail
{
    private $tickets = [];

    public function __construct(
        public int $id,
        public string $title,
        public string $content,
        public ?TeacherDetailDTO $teacher = null,
        public ?EnrollmentDetailDTO $enrollment = null,
//        public ?DailyClassDTO $daily_class = null,
//        public ?EnrollmentDTO $enrollment = null,
    ) {}

    public function addTicket(TicketDetailDTO $ticket): void
    {
        $this->tickets[] = $ticket;
    }

    public function getTickets(): array
    {
        return $this->tickets;
    }
}
