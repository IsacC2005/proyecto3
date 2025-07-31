<?php

namespace App\DTOs;

use App\DTOs\DailyClassDTO;

class ItemEvaluationDTO
{
    public function __construct(
        public int $id,
        public string $title,
        public DailyClassDTO $daily_class
    ) {}
}

?>