<?php 


namespace App\DTOs\Summary;

class TicketDTO
{
    public function __construct(
        public int $id,
        public string $average,
        public string $content,
        public string $suggestions,
        public ?int $learning_project_id = 0,
        public ?int $student_id = 0
    ) {}
}
?>