<?php

namespace App\DTOs\Details;

use App\DTOs\Summary\EvaluationItemsStudentDTO;

class StudentDetailDTO implements DTODetail
{
    private $enrollments = [];
    private $ticket = [];
    private $evaluationItemStudent = [];


    public function __construct(
        public int $id,
        public int $grade,
        public string $name,
        public string $surname,
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

    public function addEvaluationItemStudent(EvaluationItemsStudentDTO $item): void
    {
        $this->evaluationItemStudent[] = $item;
    }

    public function getEvaluationItemsStudent(): array
    {
        return $this->evaluationItemStudent;
    }
}
