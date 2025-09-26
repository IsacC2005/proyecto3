<?php

namespace App\Repositories\Interfaces;

use App\DTOs\Summary\EnrollmentDTO;
use App\DTOs\Details\EnrollmentDetailDTO;

interface EnrollmentInterface
{
    public function create(EnrollmentDTO $enrollment): EnrollmentDTO;

    public function assignTeacher(int $enrollmentId, int $teacherId): bool;

    public function teacherItsAssing(int $enrollmentId, int $teacherId): bool;

    public function addStudent(int $enrollmentId, int $studentId): bool;

    public function studentItsAdd(int $enrollmentId, int $studentId): bool;

    public function studentItsAddInGrade(int $grade, int $studentId): bool;

    public function find(int $id, ?string $fn = null): EnrollmentDTO;

    public function findAll(?String $f = null): array;

    public function findByYearSchool(String $year, ?string $fn = null): array;

    public function findByTeacher(int $teacherId, ?String $f = null): array;

    public function findByStudent(int $studentId): array;

    public function findByLearningProject(int $learningProject): EnrollmentDTO;

    public function findEnrollmentOnSchoolYearByTeacher(int $teacherId, string $schoolYear): array;

    public function findEnrollmentOnSchoolYearAndSchoolMomentByTeacher(int $teacherId, string $schoolYear, int $schoolMoment): EnrollmentDTO | null;

    public function existEnrollmentSecctionAndSchoolYear(int $grade, string $section, int $moment, string $year): bool;

    public function search(EnrollmentDTO $enrollment): array;

    public function update(EnrollmentDTO $enrollment): EnrollmentDTO;

    public function delete(int $id): void;
}
