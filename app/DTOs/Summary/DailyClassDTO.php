<?php


namespace App\DTOs\Summary;

use DateTime;

class DailyClassDTO implements DTOSummary
{

    private $itemEvaluationIds = [];

    public function __construct(
        public int $id,
        public int $trainingAreaId,
        public DateTime $date,
        public string $title,
        public string $content,
        public int $learningProjectId
    ) {}

    public function addItemEvaluation(int $itemEvaluationId): void
    {
        $this->itemEvaluationIds[] = $itemEvaluationId;
    }

    public function getItemEvaluations(): array
    {
        return $this->itemEvaluationIds;
    }
}
