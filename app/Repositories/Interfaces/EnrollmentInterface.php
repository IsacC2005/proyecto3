<?php

namespace App\Repositories\Interfaces;

use App\DTOs\Summary\EnrollmentDTO;
use App\DTOs\Details\EnrollmentDetailDTO;

interface EnrollmentInterface
{
    public function create(EnrollmentDTO $enrollment): EnrollmentDTO;

    public function assignTeacher(int $id_teacher, int $id_enrollment): bool;

    public function addStudent(int $enrollment_id, int $student_id): bool;

    public function find(int $id): EnrollmentDTO;

    public function findAll(?String $f = null): array;

    public function findByTeacher(int $teacher_id, ?String $f = null): array;

    public function findByStudent(int $student_id): array;

    public function findByLearningProject(int $learningProject): EnrollmentDTO;

    public function search(EnrollmentDTO $enrollment): array;

    public function update(EnrollmentDTO $enrollment): EnrollmentDTO;

    public function delete($id): void;
}
