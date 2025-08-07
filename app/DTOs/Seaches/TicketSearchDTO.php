<?php 


namespace App\DTOs\Searches;

class TicketSearchDTO
{
    public function __construct(
        public ?int $id = null,
        public ?string $average = null,
        public ?string $content = null,
        public ?string $suggestions = null,
        public ?int $learning_project_id = null,
        public ?int $student_id = null
    ) {}
}
?>