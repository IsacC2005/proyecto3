<?php

namespace App\Repositories;

use App\DTOs\EnrollmentDTO;
use App\Models\Enrollment;
use App\Models\LearningProject;
use App\Models\Student;
use App\Models\Teacher;
use App\Repositories\interfaces\EnrollmentInterface;
use App\Repositories\Traits\EnrollmentTrait;

class EnrollmentRepository implements EnrollmentInterface
{


    use EnrollmentTrait;


    public function create(EnrollmentDTO $enrollment): bool{
        $enrollmentModel = Enrollment::create([
            'school_year' => $enrollment->school_year,
            'school_moment' => $enrollment->school_moment,
            'section' => $enrollment->section,
            'classroom' => $enrollment->classroom,
            'teacher_id' => $enrollment->teacher_id,
        ]);

        if(!$enrollmentModel) {
            return false;
        }

        return true;
    }



    public function find($id): EnrollmentDTO | null{
        $enrollmentModel = Enrollment::find($id);
        if (!$enrollmentModel) {
            return null;
        }

        return $this->transformToDTO($enrollmentModel);
    }



    public function findAll(): array
    {
        $enrollmentModel = Enrollment::all();

        return $this->transformListDTO($enrollmentModel->toArray());
    }



    public function findByTeacher(int $teacher_id): array
    {
        $enrollments = Enrollment::where('teacher_id', $teacher_id)->get();
        return $this->transformListDTO($enrollments->toArray());
    }

    public function findByStudent(int $student): array{
        $studentModel = Student::find($student);
        if (!$studentModel) {
            return [];
        }

        $EnrollmentStudentModle = $studentModel->Enrollments()->get();
        if ($EnrollmentStudentModle->isEmpty()) {
            return [];
        }
        return $this->transformListDTO($EnrollmentStudentModle->toArray());
    }

    public function findByLearningProject(int $learning_project_id): EnrollmentDTO | null
    {
        $project = LearningProject::find($learning_project_id);
        if(!$project){
            return null;
        }

        $enrollment = Enrollment::find($project->id);

        return $this->transformToDTO($enrollment);
    }

    public function search(EnrollmentDTO $enrollment): array
    {
        return [];
    }

    public function update(EnrollmentDTO $enrollment): bool
    {
        $enrollmentModel = Enrollment::find($enrollment->id);

        if(!$enrollmentModel){
            return false;
        }

        $enrollmentModel->school_year = $enrollment->school_year;
        $enrollmentModel->school_moment = $enrollment->school_moment;
        $enrollmentModel->section = $enrollment->section;
        $enrollmentModel->clasroom = $enrollment->classroom;

        if($enrollment->teacher_id){
            $teacher = Teacher::find($enrollment->teacher_id);
            if($teacher){
                $enrollmentModel->teacher()->associate($teacher);
            }
        }

        if($enrollment->learning_project){
            $project = LearningProject::find($enrollment->learning_project);
            if($project){
                $enrollmentModel->learning_project()->associate($project);
            }
        }

        return $enrollmentModel->save();

    }

    public function delete($id): bool
    {
        $enrollmentModel = Enrollment::find($id);
        if($enrollmentModel){
            return false;
        }

        return $enrollmentModel->delete();
    }
}
?>