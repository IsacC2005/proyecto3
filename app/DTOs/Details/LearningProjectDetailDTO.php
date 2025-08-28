<?php


namespace App\DTOs\Details;

use App\DTOs\Summary\DailyClassDTO;
use App\DTOs\Summary\EnrollmentDTO;
use App\Models\DailyClass;

class LearningProjectDetailDTO implements DTODetail
{
    private array $tickets = [];
    private array $DailyClass = [];

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

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'teacher' => $this->teacher ?? null,
            'enrollment' => $this->enrollment ?? null,
            'daily_classes' => $this->getDailyClasses()
        ];
    }
}
