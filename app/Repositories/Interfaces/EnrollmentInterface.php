<?php

namespace App\Repositories\Interfaces;

use App\DTOs\Summary\EnrollmentDTO;
use App\DTOs\Details\EnrollmentDetailDTO;

interface EnrollmentInterface
{
    public function create(EnrollmentDTO $enrollment): EnrollmentDTO;

    public function assignTeacher(int $id_enrollment, int $id_teacher): bool;

    public function teacherItsAssing(int $enrollment_id, int $teacher_id): bool;

    public function addStudent(int $enrollment_id, int $student_id): bool;

    public function find(int $id): EnrollmentDTO;

    public function findAll(?String $f = null): array;

    public function findByTeacher(int $teacher_id, ?String $f = null): array;

    public function findByStudent(int $student_id): array;

    public function findByLearningProject(int $learningProject): EnrollmentDTO;

    public function findEnrollmentOnSchoolYearByTeacher(int $teacher_id, string $school_year): array;

    public function findEnrollmentOnSchoolYearAndSchoolMomentByTeacher(int $teacher_id, string $school_year, int $school_moment): EnrollmentDTO | null;

    public function search(EnrollmentDTO $enrollment): array;

    public function update(EnrollmentDTO $enrollment): EnrollmentDTO;

    public function delete($id): void;
}
