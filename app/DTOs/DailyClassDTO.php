<?php 


namespace App\DTOs;

use App\DTOs\ItemEvaluationDTO;
use DateTime;

class DailyClassDTO
{

    private $item_evaluations = [];

    public function __construct(
        public int $id,
        public DateTime $date,
        public string $title,
        public string $content,
        public ?LearningProjectDTO $learning_project = null
    ) {}

    public function addItemEvaluation(ItemEvaluationDTO $itemEvaluation): void
    {
        $this->item_evaluations[] = $itemEvaluation;
    }

    public function getItemEvaluations(): array
    {
        return $this->item_evaluations;
    }
}
?>