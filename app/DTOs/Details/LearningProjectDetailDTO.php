<?php


namespace App\DTOs\Details;

use App\DTOs\Summary\DailyClassDTO;
use App\DTOs\Summary\EnrollmentDTO;
use App\Models\DailyClass;

class LearningProjectDetailDTO implements DTODetail
{
    private array $tickets = [];
    public array $DailyClass = [];

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

    public function addDailyClasses(DailyClassDTO $DailyClass): void
    {
        $this->DailyClass[] = $DailyClass;
    }

    public function getDailyClasses(): array
    {
        return $this->DailyClass;
    }
}
