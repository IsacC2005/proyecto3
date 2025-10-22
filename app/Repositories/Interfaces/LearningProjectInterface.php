<?php

namespace App\Repositories\Interfaces;

use App\Constants\TDTO;
use App\DTOs\Details\LearningProjectDetailDTO;
use App\DTOs\Summary\LearningProjectDTO;
use App\DTOs\PaginationDTO;

interface LearningProjectInterface
{
    public function create(LearningProjectDetailDTO $learningProject): LearningProjectDTO;

    public function existProject(int $id): bool;

    public function existProjectForTeacher(int $project_id, int $teacher_id): bool;

    public function existProjectByTeacheByYearByMoment(int $teacherId, int $enrollmentId, int $schoolMoment): bool;

    public function find(int $id, ?string $fn = null): LearningProjectDTO | LearningProjectDetailDTO;

    public function findAll(?string $fn = null): array;

    public function findByEnrollment(int $enrollmentId): array;

    public function findByEnrollmentAndMoment(int $enrollmentId, int $moment): LearningProjectDTO | null;

    public function findByTeacher(int $teacherId, ?string $fn = null): PaginationDTO;

    public function findOnDate(string $schoolYear, string $schoolMoment, ?int $teacher_id, ?string $fn = TDTO::SUMMARY): LearningProjectDTO | LearningProjectDetailDTO | null;

    public function getAllEvaluationByProject(int $projectId): array;

    public function getAllNoteStudent(int $projectId, int $studentId): array;

    public function countStudents(int $projectId): int;

    public function search(LearningProjectDTO $learningProject): array;

    public function update(LearningProjectDTO $learningProject): LearningProjectDTO;

    public function delete(int $id): void;
}
