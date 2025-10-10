<?php


namespace App\DTOs\Summary;


class LearningProjectDTO implements DTOSummary
{
    private $ticketIds = [];

    public function __construct(
        public int $id,
        public string $title,
        public string $content,
        public int $schoolMoment,
        public ?int $teacherId = 0,
        public ?int $enrollmentId = 0,
        //        public ?DailyClassDTO $daily_class = null,
        //        public ?EnrollmentDTO $enrollment = null,
    ) {}

    public function addTicket(int $ticketId): void
    {
        $this->ticketIds[] = $ticketId;
    }

    public function getTickets(): array
    {
        return $this->ticketIds;
    }
}
