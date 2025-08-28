<?php

namespace App\DTOs\Details;

class EvaluationItemsStudentDetailDTO implements DTODetail
{
    public function __construct(
        public ItemEvaluationDetailDTO $itemEvaluation,
        public StudentDetailDTO $student,
        public string $note
    ) {}
}
