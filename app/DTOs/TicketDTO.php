<?php 


namespace App\DTOs;

class TicketDTO
{
    public function __construct(
        public int $id,
        public string $average,
        public string $content,
        public string $suggestions,
        public int $learning_project_id,
        public int $student_id
    ) {}
}
?>