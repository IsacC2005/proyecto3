<?php

namespace App\DTOs\Summary;

class StudentDTO implements DTOSummary
{
    private $enrollmentIds = [];
    private $ticketIds = [];
    private $evaluationItemsStudentIds = [];


    public function __construct(
        public int $id,
        public string $schoolId,
        public int $grade,
        public string $name,
        public string $surname,
    ) {}


    public function addEnrollment(int  $enrollmentId): void
    {
        $this->enrollmentIds[] = $enrollmentId;
    }

    public function getEnrollments(): array
    {
        return $this->enrollmentIds;
    }

    public function addTicket(int $ticketId): void
    {
        $this->ticketIds[] = $ticketId;
    }

    public function getTickets(): array
    {
        return $this->ticketIds;
    }

    public function addEvaluationItemStudent(int $itemId): void
    {
        $this->evaluationItemsStudentIds[] = $itemId;
    }

    public function getEvaluationItemsStudent(): array
    {
        return $this->evaluationItemsStudentIds;
    }
}
