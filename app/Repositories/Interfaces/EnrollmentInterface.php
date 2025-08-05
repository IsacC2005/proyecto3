<?php

namespace App\Repositories\Interfaces;

use App\DTOs\EnrollmentDTO;
use App\DTOs\LearningProjectDTO;
use App\DTOs\StudentDTO;
use App\DTOs\TeacherDTO;
use SebastianBergmann\Type\NullType;

interface EnrollmentInterface
{
    public function create(EnrollmentDTO $enrollment): bool;

    public function find($id): EnrollmentDTO | null;

    public function findAll(): array;

    public function findByTeacher(int $teacher_id): array;

    public function findByStudent(int $student_id): array;

    public function findByLearningProject(int $learningProject): EnrollmentDTO | Null;

    public function search(EnrollmentDTO $enrollment): array;

    public function update(EnrollmentDTO $enrollment): bool;

    public function delete($id): bool;
}
?>