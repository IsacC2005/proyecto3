<?php

namespace App\DTOs\Searches;

class EvaluationItemsStudentSearchDTO implements DTOSearch
{
    public function __construct(
        public ?int $item_evaluation_id = null,
        public ?int $student_id = null,
        public ?string $note = null
    ) {}
}
?>
