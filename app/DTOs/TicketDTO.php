<?php 


namespace App\DTOs;

class TicketDTO
{
    public function __construct(
        public int $id,
        public string $average,
        public string $content,
        public string $suggestions,
        public ?LearningProjectDTO $learning_project = null,
        public ?StudentDTO $student = null
    ) {}
}
?>