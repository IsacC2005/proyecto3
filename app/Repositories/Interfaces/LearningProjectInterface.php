<?php

namespace App\Repositories\Interfaces;

use App\DTOs\Details\LearningProjectDetailDTO;
use App\DTOs\Summary\LearningProjectDTO;

interface LearningProjectInterface
{
    public function create(LearningProjectDetailDTO $learningProject): LearningProjectDTO;

    public function find($id): LearningProjectDTO;

    public function findAll(): array;

    public function findByEnrollment(int $enrollment_id): LearningProjectDTO | null;

    public function findByTeacher(int $teacher_id): array;

    public function search(LearningProjectDTO $learningProject): array;

    public function update(LearningProjectDTO $learningProject): LearningProjectDTO;

    public function delete($id): void;
}
