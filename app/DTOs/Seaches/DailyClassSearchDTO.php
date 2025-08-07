<?php 


namespace App\DTOs\Searches;

use App\DTOs\ItemEvaluationDTO;
use DateTime;

class DailyClassSearchDTO
{

    private $item_evaluation_ids = [];

    public function __construct(
        public ?int $id = null,
        public ?DateTime $date = null,
        public ?string $title = null,
        public ?string $content = null,
        public ?int $learning_project_id = null
    ) {}

    public function addItemEvaluation(ItemEvaluationDTO $itemEvaluation): void
    {
        $this->item_evaluation_ids[] = $itemEvaluation;
    }

    public function getItemEvaluations(): array
    {
        return $this->item_evaluation_ids;
    }
}
?>