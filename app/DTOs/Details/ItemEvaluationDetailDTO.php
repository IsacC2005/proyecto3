<?php

namespace App\DTOs\Details;

class ItemEvaluationDetailDTO implements DTODetail
{
    public function __construct(
        public int $id,
        public string $title,
        public ?DailyClassDetailDTO $dailyClass = null
    ) {}
}
