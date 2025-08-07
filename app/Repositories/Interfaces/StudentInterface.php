<?php 

namespace App\Repositories\Interfaces;

use App\DTOs\DailyClassDTO;
use App\DTOs\EnrollmentDTO;
use App\DTOs\LearningProjectDTO;
use App\DTOs\RepresentativeDTO;
use App\DTOs\StudentDTO;
use App\Models\Student;

interface StudentInterface
{
    public function create(StudentDTO $student): StudentDTO;

    public function find($id): StudentDTO;

    public function findAll(): array;

    public function findByName($name): StudentDTO;

    public function findByEnrollment(int $enrollment_id): array;

    public function findByLearningProject(int $learning_project_id): array;

    public function findByDailyClass(int $daily_class_id): array;

    public function findByRepresentative(int $representative_id): array;

    public function update(StudentDTO $student): StudentDTO;

    public function delete($id): void;
}
?>