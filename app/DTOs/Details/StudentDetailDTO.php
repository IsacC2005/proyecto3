<?php 

namespace App\DTOs\Details;

class StudentDetailDTO
{
    private $enrollments = [];
    private $ticket = [];
    private $evaluation_items_student = [];


    public function __construct(
        public int $id,
        public int $degree,
        public string $name,
        public string $surname,
        public RepresentativeDetailDTO $representative,
    ) {}


    public function addEnrollment(EnrollmentDetailDTO  $enrollment): void
    {
        $this->enrollments[] = $enrollment;
    }

    public function getEnrollments(): array
    {
        return $this->enrollments;
    }

    public function addTicket(TicketDetailDTO $ticket): void
    {
        $this->ticket[] = $ticket;
    }

    public function getTickets(): array
    {
        return $this->ticket;
    }

    public function addEvaluationItemStudent(EvaluationItemsStudentDetailDTO $item): void
    {
        $this->evaluation_items_student[] = $item;
    }

    public function getEvaluationItemsStudent(): array
    {
        return $this->evaluation_items_student;
    }
}
?>