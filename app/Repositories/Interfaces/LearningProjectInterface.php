<?php

namespace App\Repositories\Interfaces;

use App\DTOs\Summary\LearningProjectDTO;

interface LearningProjectInterface
{
    public function create(LearningProjectDTO $learningProject): LearningProjectDTO;

    public function find($id): LearningProjectDTO;

    public function findAll(): array;

    public function findByTeacher(int $teacher_id): array;

    public function search(LearningProjectDTO $learningProject): array;

    public function update(LearningProjectDTO $learningProject): LearningProjectDTO;

    public function delete($id): void;
}
?>