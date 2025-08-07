<?php

namespace App\DTOs;


class ItemEvaluationDTO
{
    public function __construct(
        public int $id,
        public string $title,
        public ?int $daily_class_id = 0
    ) {}
}

?>