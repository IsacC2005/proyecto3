<?php 

namespace App\DTOs;

class EvaluationItemsStudentDTO
{
    public function __construct(
        public ItemEvaluationDTO $item_evaluation,
        public StudentDTO $student,
    ) {}
}
?>