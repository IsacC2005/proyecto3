<?php


namespace App\Repositories\Interfaces;

use App\DTOs\DailyClassDTO;
use App\DTOs\LearningProjectDTO;
use App\DTOs\TeacherDTO;

interface DailyClassInterface
{
    public function create(DailyClassDTO $dailyClass): bool;

    public function find($id): DailyClassDTO | null;

    public function findAll(): array;

    public function findByLearningProject(LearningProjectDTO $learningProject): array;

    public function search(DailyClassDTO $dailyClass): array;

    public function update(DailyClassDTO $dailyClass): bool;

    public function delete($id): bool;
}
?>