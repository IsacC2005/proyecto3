<?php


namespace App\DTOs\Details;

use App\DTOs\Details\LearningProjectDetailDTO;

class TicketDetailDTO implements DTODetail
{
    public function __construct(
        public int $id,
        public string $average,
        public string $content,
        public string $suggestions,
        public ?LearningProjectDetailDTO $learningProject = null,
        public ?StudentDetailDTO $student = null
    ) {}
}
