<?php


namespace App\Repositories\Interfaces;

use App\DTOs\DailyClassDTO;
use App\DTOs\LearningProjectDTO;
use App\DTOs\TeacherDTO;

interface DailyClassInterface
{
    public function create(DailyClassDTO $dailyClass): DailyClassDTO;

    public function find($id): DailyClassDTO;

    public function findAll(): array;

    public function findByLearningProject(LearningProjectDTO $learningProject): array;

    public function search(DailyClassDTO $dailyClass): array;

    public function update(DailyClassDTO $dailyClass): DailyClassDTO;

    public function delete($id): void;
}
?>