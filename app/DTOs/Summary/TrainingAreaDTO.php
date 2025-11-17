<?php

namespace App\DTOs\Summary;

class TrainingAreaDTO implements DTOSummary
{
    public function __construct(
        public int $id,
        public string $title
    ) {}
}
