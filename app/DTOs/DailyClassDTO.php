<?php 


namespace App\DTOs;

use DateTime;

class DailyClassDTO
{

    private $item_evaluation_ids = [];

    public function __construct(
        public int $id,
        public DateTime $date,
        public string $title,
        public string $content,
        public int $learning_project_id
    ) {}

    public function addItemEvaluation(int $itemEvaluation_id): void
    {
        $this->item_evaluation_ids[] = $itemEvaluation_id;
    }

    public function getItemEvaluations(): array
    {
        return $this->item_evaluation_ids;
    }
}
?>