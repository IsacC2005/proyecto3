<?php 


namespace App\Repositories\Interfaces;

use App\DTOs\ItemEvaluationDTO;

interface ItemEvaluationInterface
{
    public function create(ItemEvaluationDTO $itemEvaluation): ItemEvaluationDTO;

    public function find($id): ItemEvaluationDTO;

    public function findAll(): array;

    public function update(ItemEvaluationDTO $itemEvaluation): ItemEvaluationDTO;

    public function delete($id): void;
}
?>