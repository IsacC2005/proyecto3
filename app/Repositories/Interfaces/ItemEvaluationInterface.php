<?php 


namespace App\Repositories\Interfaces;

use App\DTOs\ItemEvaluationDTO;

interface ItemEvaluationInterface
{
    public function create(ItemEvaluationDTO $itemEvaluation): bool;

    public function find($id): ItemEvaluationDTO | null;

    public function findAll(): array;

    public function update(ItemEvaluationDTO $itemEvaluation): bool;

    public function delete($id): bool;
}
?>