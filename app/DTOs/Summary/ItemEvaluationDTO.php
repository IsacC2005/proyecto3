<?php

namespace App\DTOs\Summary;


class ItemEvaluationDTO implements DTOSummary
{
    public function __construct(
        public int $id,
        public string $title,
        public ?int $daily_class_id = 0
    ) {}
}

?>