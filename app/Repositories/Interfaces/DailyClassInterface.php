<?php


namespace App\Repositories\Interfaces;

use App\DTOs\Details\DailyClassDetailDTO;
use App\DTOs\Summary\DailyClassDTO;

interface DailyClassInterface
{
    public function create(DailyClassDTO | DailyClassDetailDTO $dailyClass): DailyClassDTO;

    public function find(int $id, ?string $fn = null): DailyClassDTO | DailyClassDetailDTO;

    public function findAll(?string $fn = null): array;

    public function findByLearningProject(int $projectId, ?string $fn = null): array;

    public function search(DailyClassDTO $dailyClass): array;

    public function update(DailyClassDetailDTO $dailyClass): DailyClassDetailDTO;

    public function delete(int $id): void;
}
