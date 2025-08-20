<?php

namespace App\DTOs\Searches;

class StudentSearchDTO implements DTOSearch
{
    private $enrollment_ids = [];
    private $ticket_ids = [];
    private $evaluation_items_student_ids = [];


    public function __construct(
        public ?int $id = null,
        public ?int $degree = null,
        public ?string $name = null,
        public ?string $surname = null,
        public ?int $representative_id = null,
    ) {}


    public function addEnrollment(int  $enrollment_id): void
    {
        $this->enrollment_ids[] = $enrollment_id;
    }

    public function getEnrollments(): array
    {
        return $this->enrollment_ids;
    }

    public function addTicket(int $ticket_id): void
    {
        $this->ticket_ids[] = $ticket_id;
    }

    public function getTickets(): array
    {
        return $this->ticket_ids;
    }

    public function addEvaluationItemStudent(int $item_id): void
    {
        $this->evaluation_items_student_ids[] = $item_id;
    }

    public function getEvaluationItemsStudent(): array
    {
        return $this->evaluation_items_student_ids;
    }
}
?>
