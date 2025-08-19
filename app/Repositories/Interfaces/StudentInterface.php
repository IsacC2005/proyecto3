<?php

namespace App\Repositories\Interfaces;

use App\DTOs\PaginationDTO;
use App\DTOs\Summary\StudentDTO;

interface StudentInterface
{
    public function createStudent(StudentDTO $student): StudentDTO;

    public function findStudentById($id): StudentDTO;

    public function findAllStudent(): PaginationDTO;

    public function findStudentByName($name): StudentDTO;

    public function findStudentByEnrollment(int $enrollment_id): array;

    public function findStudentByLearningProject(int $learning_project_id): array;

    public function findStudentByDailyClass(int $daily_class_id): array;

    public function findStudentByRepresentative(int $representative_id): array;

    public function updateStudent(StudentDTO $student): StudentDTO;

    public function deleteStudent($id): void;
}
?>
