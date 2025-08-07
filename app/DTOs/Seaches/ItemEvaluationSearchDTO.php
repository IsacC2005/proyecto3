<?php

namespace App\DTOs\Searches;


class ItemEvaluationSearchDTO
{
    public function __construct(
        public ?int $id = null,
        public ?string $title = null,
        public ?int $daily_class_int = null
    ) {}
}

?>