<?php

namespace App\Repositories;

use App\DTOs\Details\StudentDetailDTO;
use App\Repositories\Interfaces\StudentInterface;
use App\DTOs\Summary\StudentDTO;
use App\DTOs\PaginationDTO;
use App\Models\DailyClass;
use App\Models\LearningProject;
use App\Repositories\TransformDTOs\TransformDTOs;
use Illuminate\Support\Facades\Http;

class ApiStudentRepository extends TransformDTOs implements StudentInterface
{
    public function createStudent(StudentDTO $student): StudentDTO
    {
        // TODO
    }

    public function findStudentById($id): StudentDTO
    {
        // TODO
    }

    public function findAllStudent(?string $fn = null): PaginationDTO
    {
        // TODO
    }

    public function findStudentByName($name): StudentDTO
    {
        // TODO
    }

    public function findStudentByEnrollment(int $enrollmentId): array
    {
        // TODO
    }

    public function findStudentByGrade(int $degree, ?bool $NotAddEnrollment = null): PaginationDTO
    {
        // TODO
    }

    public function findStudentByLearningProject(int $learningProjectId): array
    {
        // TODO
    }

    public function findStudentByDailyClass(int $dailyClassId): array
    {
        $project = DailyClass::find($dailyClassId);

        $enrollmentId = $project->learning_project->enrollment_id;

        $japecoUrl = env('JAPECO_URL');

        $response = Http::get("$japecoUrl/api/student/to-section/$enrollmentId");

        if (!$response->successful()) {

            throw new \Exception("$japecoUrl/student/to-section/$enrollmentId");
            throw new \Exception("Error al conectar con la API: {$response->status()}");
        }

        $apiData = $response->json();

        $studentsCollection = collect($apiData['data'] ?? []);

        return $this->transformListDTO($studentsCollection);
    }

    public function findStudentByRepresentative(int $representativeId): array
    {
        // TODO
    }

    public function updateStudent(StudentDTO $student): StudentDTO
    {
        // TODO
    }

    public function deleteStudent(int $id): void
    {
        // TODO
    }

    protected function transformToDTO($model): StudentDTO
    {
        return new StudentDTO(
            id: $model['id'],
            grade: -1,
            name: $model['name'],
            surname: ''
        );
    }

    protected function transformToDetailDTO($model): StudentDetailDTO {}
}
