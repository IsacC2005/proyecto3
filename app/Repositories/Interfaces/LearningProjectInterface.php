<?php

namespace App\Repositories\Interfaces;

use App\DTOs\Details\LearningProjectDetailDTO;
use App\DTOs\Summary\LearningProjectDTO;

interface LearningProjectInterface
{
    public function create(LearningProjectDetailDTO $learningProject): LearningProjectDTO;

    public function find(int $id, ?string $fn = null): LearningProjectDTO | LearningProjectDetailDTO;

    public function findAll(?string $fn = null): array;

    public function findByEnrollment(int $enrollmentId): LearningProjectDTO | null;

    public function findByTeacher(int $teacherId, ?string $fn = null): array;

    public function search(LearningProjectDTO $learningProject): array;

    public function update(LearningProjectDTO $learningProject): LearningProjectDTO;

    public function delete(int $id): void;
}
