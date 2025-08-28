<?php

namespace App\Repositories\Interfaces;

use App\DTOs\PaginationDTO;
use App\DTOs\Summary\StudentDTO;

interface StudentInterface
{
    public function createStudent(StudentDTO $student): StudentDTO;

    public function findStudentById($id): StudentDTO;

    public function findAllStudent(?string $fn = null): PaginationDTO;

    public function findStudentByName($name): StudentDTO;

    public function findStudentByEnrollment(int $enrollmentId): array;

    public function findStudentByDegree(int $degree, ?bool $NotAddEnrollment = false): PaginationDTO;

    public function findStudentByLearningProject(int $learningProjectId): array;

    public function findStudentByDailyClass(int $dailyClassId): array;

    public function findStudentByRepresentative(int $representativeId): array;

    public function updateStudent(StudentDTO $student): StudentDTO;

    public function deleteStudent(int $id): void;
}
