<?php


namespace App\Repositories\Interfaces;

use App\DTOs\Summary\DailyClassDTO;

interface DailyClassInterface
{
    public function create(DailyClassDTO $dailyClass): DailyClassDTO;

    public function find($id): DailyClassDTO;

    public function findAll(): array;

    public function findByLearningProject(int $project_id): array;

    public function search(DailyClassDTO $dailyClass): array;

    public function update(DailyClassDTO $dailyClass): DailyClassDTO;

    public function delete($id): void;
}
?>