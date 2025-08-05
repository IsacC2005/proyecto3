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
    public function create(StudentDTO $student): bool;

    public function find($id): StudentDTO | null;

    public function findAll(): array;

    public function findByName($name): StudentDTO | null;

    public function findByEnrollment(int $enrollment_id): array;

    public function findByLearningProject(int $learning_project_id): array;

    public function findByDailyClass(int $daily_class_id): array;

    public function findByRepresentative(int $representative_id): array;

    public function update(StudentDTO $student): bool;

    public function delete($id): bool;
}
?>