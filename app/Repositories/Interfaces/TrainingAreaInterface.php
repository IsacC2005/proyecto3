<?php

namespace App\Repositories\Interfaces;

use App\DTOs\Summary\TrainingAreaDTO;



interface TrainingAreaInterface
{
    public function create(TrainingAreaDTO $trainingArea): TrainingAreaDTO | null;
    public function find(int $id): TrainingAreaDTO | null;
    public function findAll(): array;
    public function delete(int $id): void;
}
