<?php

namespace App\Repositories;

use App\Constants\TDTO;
use App\Repositories\Interfaces\EnrollmentInterface;
use App\Repositories\TransformDTOs\TransformDTOs;
use App\DTOs\Summary\EnrollmentDTO;
use Illuminate\Database\Eloquent\Model;
use App\DTOs\Summary\DTOSummary;
use App\DTOs\Details\EnrollmentDetailDTO;
use App\Factories\StudentFactory;
use App\Factories\TeacherFactory;
use Illuminate\Support\Facades\Http;

class ApiEnrollmentRepository extends TransformDTOs implements EnrollmentInterface
{
    public function create(EnrollmentDTO $enrollment): EnrollmentDTO
    {
        // TODO
    }

    public function assignTeacher(int $enrollmentId, int $teacherId): bool
    {
        // TODO
    }

    public function teacherItsAssing(int $enrollmentId, int $teacherId): bool
    {
        $japecoUrl = env('JAPECO_URL');
        $response = Http::get("$japecoUrl/api/section/teacher-if-assing", [
            'enrollmentId' => $enrollmentId,
            'teacherId' => $teacherId
        ]);

        if (!$response->successful()) {
            throw new \Exception("Error al conectar con la API: {$response->status()}");
        }
        $apiData = $response->json();

        return $apiData['data'];
    }

    public function addStudent(int $enrollmentId, int $studentId): bool
    {
        // TODO
    }

    public function studentItsAdd(int $enrollmentId, int $studentId): bool
    {
        // TODO
    }

    public function studentItsAddInGrade(int $grade, int $studentId): bool
    {
        // TODO
    }

    public function find(int $id, ?string $fn = null): EnrollmentDTO
    {
        // TODO
    }

    public function findAll(?string $f = TDTO::SUMMARY): array
    {
        $japecoUrl = env('JAPECO_URL');
        $response = Http::get("$japecoUrl/api/section/details");

        if (!$response->successful()) {
            throw new \Exception("Error al conectar con la API: {$response->status()}");
        }
        $apiData = $response->json();

        $sectionDataCollection = collect($apiData['data'] ?? []);

        return $this->transformListDTO($sectionDataCollection, $f);
    }

    public function findByYearSchool(string $year, ?string $fn = null): array
    {
        $japecoUrl = env('JAPECO_URL');
        $response = Http::get("$japecoUrl/api/section/school-year/details");

        if (!$response->successful()) {
            throw new \Exception("Error al conectar con la API: {$response->status()}");
        }
        $apiData = $response->json();

        $sectionDataCollection = collect($apiData['data'] ?? []);

        return $this->transformListDTO($sectionDataCollection, $fn);
    }

    public function findByTeacher(int $teacherId, ?string $f = null): array
    {

        $japecoUrl = env('JAPECO_URL');
        $response = Http::get("$japecoUrl/api/section/assings-teacher/$teacherId");

        if (!$response->successful()) {
            throw new \Exception("Error al conectar con la API: {$response->status()}}");
        }
        $apiData = $response->json();

        $sectionDataCollection = collect($apiData['data'] ?? []);

        return $this->transformListDTO($sectionDataCollection, $f);
    }

    public function findByStudent(int $studentId): array
    {
        // TODO
    }

    public function findByLearningProject(int $learningProject): EnrollmentDTO
    {
        // TODO
    }

    public function findEnrollmentOnSchoolYearByTeacher(int $teacherId, string $schoolYear): array
    {
        // TODO
    }

    public function findEnrollmentOnSchoolYearAndSchoolMomentByTeacher(int $teacherId, string $schoolYear, int $schoolMoment): EnrollmentDTO | null
    {
        $japecoUrl = env('JAPECO_URL');
        $response = Http::get("$japecoUrl/api/section/find/school-year-and-teacher-id", [
            "schoolYear" => $schoolYear,
            "teacherId" => $teacherId
        ]);

        if (!$response->successful()) {
            throw new \Exception("Error al conectar con la API: {$response->status()}");
        }
        $apiData = $response->json();

        return $this->transformToDTO($apiData['data']);
    }

    public function existEnrollmentSecctionAndSchoolYear(int $grade, string $section, int $moment, string $year): bool
    {
        // TODO
    }

    public function search(EnrollmentDTO $enrollment): array
    {
        // TODO
    }

    public function update(EnrollmentDTO $enrollment): EnrollmentDTO
    {
        // TODO
    }

    public function delete(int $id): void
    {
        // TODO
    }

    protected function transformToDTO($model): EnrollmentDTO
    {
        return new EnrollmentDTO(
            id: $model['id'],
            schoolYear: $model['schoolYear'],
            schoolMoment: '1',
            grade: $model['grade'],
            section: $model['section'],
            classroom: 0,

        );
    }

    protected function transformToDetailDTO($model): EnrollmentDetailDTO
    {
        $enrollment = new EnrollmentDetailDTO(
            id: $model['id'],
            schoolYear: $model['school-year'],
            schoolMoment: '1',
            grade: $model['grade'],
            section: $model['section'],
            classroom: 0,
            teacher: isset($model['teacher'][0])
                ? TeacherFactory::fromArrayDetail([
                    'id' => $model['teacher'][0]['id'] ?? null,
                    'name' => $model['teacher'][0]['name'] ?? '',
                    'surname' => $model['teacher'][0]['surname'] ?? ''
                ])
                : null,
            // learningProject: $model->learning_project ? LearningProjectFactory::fromArrayDetail(['id' => $model->learning_project->id, 'title' => $model->learning_project->title]) : null
        );

        if (isset($model['students']) && is_array($model['students'])) {
            foreach ($model['students'] as $student) {
                $enrollment->addStudent(StudentFactory::fromArrayDetail([
                    'id' => $student['id'] ?? null,
                    'grade' => 0,
                    'name' => $student['name'] ?? '',
                    'surname' => $student['surname'] ?? ''
                ]));
            }
        }

        return $enrollment;
    }
}
