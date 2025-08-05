<?php

namespace App\Repositories\Interfaces;

use App\DTOs\LearningProjectDTO;
use App\DTOs\TeacherDTO;
use App\Models\LearningProject;

interface LearningProjectInterface
{
    public function create(LearningProjectDTO $learningProject): bool;

    public function find($id): LearningProjectDTO | null;

    public function findAll(): array;

    public function findByTeacher(int $teacher_id): array;

    public function search(LearningProjectDTO $learningProject): array;

    public function update(LearningProjectDTO $learningProject): bool;

    public function delete($id): bool;
}
?>