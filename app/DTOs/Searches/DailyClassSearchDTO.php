<?php

namespace App\DTOs\Searches;

use App\DTOs\Searches\ItemEvaluationSearchDTO;
use DateTime;

class DailyClassSearchDTO implements DTOSearch
{

    private $item_evaluation_ids = [];

    public function __construct(
        public ?int $id = null,
        public ?DateTime $date = null,
        public ?string $title = null,
        public ?string $content = null,
        public ?int $learning_project_id = null
    ) {}

    public function addItemEvaluation(ItemEvaluationSearchDTO $itemEvaluation): void
    {
        $this->item_evaluation_ids[] = $itemEvaluation;
    }

    public function getItemEvaluations(): array
    {
        return $this->item_evaluation_ids;
    }
}
?>
