<?php

namespace App\DTOs\Summary;

class EvaluationItemsStudentDTO implements DTOSummary
{
    public function __construct(
        public int $itemEvaluationId,
        public int $studentId,
        public string $note
    ) {}
}
