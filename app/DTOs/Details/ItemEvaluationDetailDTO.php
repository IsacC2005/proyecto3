<?php

namespace App\DTOs\Details;

class ItemEvaluationDetailDTO
{
    public function __construct(
        public int $id,
        public string $title,
        public ?DailyClassDetailDTO $daily_class = null
    ) {}
}

?>