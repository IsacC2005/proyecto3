<?php 


namespace App\DTOs\Details;

use DateTime;

class DailyClassDetailDTO
{

    private $item_evaluations = [];

    public function __construct(
        public int $id,
        public DateTime $date,
        public string $title,
        public string $content,
        public ?LearningProjectDetailDTO $learning_project = null
    ) {}

    public function addItemEvaluation(ItemEvaluationDetailDTO $itemEvaluation): void
    {
        $this->item_evaluations[] = $itemEvaluation;
    }

    public function getItemEvaluations(): array
    {
        return $this->item_evaluations;
    }
}
?>