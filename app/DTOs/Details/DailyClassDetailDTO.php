<?php


namespace App\DTOs\Details;

use DateTime;

class DailyClassDetailDTO implements DTODetail
{

    private array $itemEvaluations = [];

    public function __construct(
        public int $id,
        public DateTime $date,
        public string $title,
        public string $content,
        public ?LearningProjectDetailDTO $learningProject = null
    ) {}

    public function addItemEvaluation(ItemEvaluationDetailDTO $itemEvaluation): void
    {
        $this->itemEvaluations[] = $itemEvaluation;
    }

    public function getItemEvaluations(): array
    {
        return $this->itemEvaluations;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'title' => $this->title,
            'content' => $this->content,
            'learningProject' => $this->learningProject,
            'indicators' => $this->getItemEvaluations()
        ];
    }
}
