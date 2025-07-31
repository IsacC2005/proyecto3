<?php 

namespace App\DTOs;

class StudentDTO
{
    private $enrollments = [];
    private $ticket = [];
    private $evaluation_items_student = [];


    public function __construct(
        public int $id,
        public string $name,
        public string $surname,
        public ?RepresentativeDTO $representative = null,
    ) {}


    public function addEnrollment(EnrollmentDTO  $enrollment): void
    {
        $this->enrollments[] = $enrollment;
    }

    public function getEnrollments(): array
    {
        return $this->enrollments;
    }

    public function addTicket(TicketDTO $ticket): void
    {
        $this->ticket[] = $ticket;
    }

    public function getTickets(): array
    {
        return $this->ticket;
    }

    public function addEvaluationItemStudent(EvaluationItemsStudentDTO $item): void
    {
        $this->evaluation_items_student[] = $item;
    }

    public function getEvaluationItemsStudent(): array
    {
        return $this->evaluation_items_student;
    }
}
?>