<?php 

namespace App\DTOs;

class EvaluationItemsStudentDTO
{
    public function __construct(
        public int $item_evaluation_id,
        public int $student_id,
        public string $note
    ) {}
}
?>