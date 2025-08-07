<?php 

namespace App\DTOs\Details;

class EvaluationItemsStudentDetailDTO
{
    public function __construct(
        public ItemEvaluationDetailDTO $item_evaluation,
        public StudentDetailDTO $student,
        public string $note
    ) {}
}
?>