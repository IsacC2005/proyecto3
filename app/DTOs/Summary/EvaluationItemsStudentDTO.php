<?php 

namespace App\DTOs\Summary;

class EvaluationItemsStudentDTO implements DTOSummary
{
    public function __construct(
        public int $item_evaluation_id,
        public int $student_id,
        public string $note
    ) {}
}
?>