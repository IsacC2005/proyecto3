<?php


namespace App\Repositories\Interfaces;

use App\DTOs\Summary\ItemEvaluationDTO;

interface ItemEvaluationInterface
{
    public function create(ItemEvaluationDTO $itemEvaluation): ItemEvaluationDTO;

    public function find(int $id): ItemEvaluationDTO;

    public function findAll(?string $fn = null): array;

    public function getAllEvaluationByClass(int $classId): array;

    public function evaluateClass(int $evaluationId, int $studentId, string $note): void;

    public function update(ItemEvaluationDTO $itemEvaluation): ItemEvaluationDTO;

    public function delete(int $id): void;

    public function deleteAllByDailyClass(int $dailyClassId): void;
}
