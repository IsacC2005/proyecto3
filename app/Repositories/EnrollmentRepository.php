<?php

namespace App\Repositories;

use App\DTOs\Summary\EnrollmentDTO;
use App\Exceptions\Enrollment\EnrollmentNotCreatedException;
use App\Exceptions\Enrollment\EnrollmentNotDeleteException;
use App\Exceptions\Enrollment\EnrollmentNotExistException;
use App\Exceptions\Enrollment\EnrollmentNotFindException;
use App\Exceptions\Enrollment\EnrollmentNotUpdateException;
use App\Exceptions\LearningProject\LearningProjectNotExistException;
use App\Exceptions\LearningProject\LearningProjectNotFindException;
use App\Exceptions\Student\StudentNotExistException;
use App\Models\Enrollment;
use App\Models\LearningProject;
use App\Models\Student;
use App\Models\Teacher;
use App\Repositories\interfaces\EnrollmentInterface;
use App\Repositories\TransformDTOs\TransformDTOs;
use App\DTOs\Summary\DTOSummary;
use Illuminate\Database\Eloquent\Model;

class EnrollmentRepository extends TransformDTOs implements EnrollmentInterface
{

    public function create(EnrollmentDTO $enrollment): EnrollmentDTO
    {

        try {
            $enrollmentModel = Enrollment::create([
                'school_year' => $enrollment->school_year,
                'school_moment' => $enrollment->school_moment,
                'degree' => $enrollment->degree,
                'section' => $enrollment->section,
                'classroom' => $enrollment->classroom,
                'teacher_id' => $enrollment->teacher_id,
            ]);

            if (!$enrollmentModel) {
                throw new EnrollmentNotCreatedException();
            }

            return $this->transformToDTO($enrollmentModel);
        } catch (\Throwable $th) {
            throw $th;
        }
    }



    public function find(int $id): EnrollmentDTO
    {
        try {
            $enrollmentModel = Enrollment::find($id);
            if (!$enrollmentModel) {
                throw new EnrollmentNotFindException();
            }

            return $this->transformToDTO($enrollmentModel);
        } catch (\Throwable $th) {
            throw new EnrollmentNotFindException();
        }
    }



    public function findAll(): array
    {
        try {
            $enrollmentModel = Enrollment::all();

            if (!$enrollmentModel) {
                throw new EnrollmentNotFindException();
            }

            return $this->transformListDTO($enrollmentModel);
        } catch (\Throwable $th) {
            throw new EnrollmentNotFindException($th->getMessage());
        }
    }



    public function findByTeacher(int $teacher_id): array
    {
        try {
            $enrollments = Enrollment::where('teacher_id', $teacher_id)->get();
            if (!$enrollments) {
                throw new EnrollmentNotFindException();
            }
            return $this->transformListDTO($enrollments->toArray());
        } catch (\Throwable $th) {
            throw new EnrollmentNotFindException();
        }
    }

    public function findByStudent(int $student_id): array
    {
        try {
            $studentModel = Student::find($student_id);
            if (!$studentModel) {
                throw new StudentNotExistException();
            }

            $EnrollmentStudentModle = $studentModel->Enrollments()->get();
            if ($EnrollmentStudentModle->isEmpty()) {
                throw new EnrollmentNotFindException();
            }
            return $this->transformListDTO($EnrollmentStudentModle->toArray());
        } catch (\Throwable $th) {
            throw new EnrollmentNotFindException();
        }
    }



    public function findByLearningProject(int $learning_project_id): EnrollmentDTO
    {
        try {
            $project = LearningProject::find($learning_project_id);
            if (!$project) {
                throw new LearningProjectNotExistException();
            }

            $enrollment = Enrollment::find($project->id);

            if (!$enrollment) {
                throw new LearningProjectNotFindException();
            }

            return $this->transformToDTO($enrollment);
        } catch (\Throwable $th) {
            throw new LearningProjectNotFindException();
        }
    }



    public function search(EnrollmentDTO $enrollment): array
    {
        return [];
    }

    public function update(EnrollmentDTO $enrollment): EnrollmentDTO
    {
        try {
            $enrollmentModel = Enrollment::find($enrollment->id);

            if (!$enrollmentModel) {
                throw new EnrollmentNotFindException();
            }

            $enrollmentModel->school_year = $enrollment->school_year;
            $enrollmentModel->school_moment = $enrollment->school_moment;
            $enrollmentModel->section = $enrollment->section;
            $enrollmentModel->clasroom = $enrollment->classroom;

            if ($enrollment->teacher_id) {
                $teacher = Teacher::find($enrollment->teacher_id);
                if ($teacher) {
                    $enrollmentModel->teacher()->associate($teacher);
                }
            }

            if ($enrollment->learning_project) {
                $project = LearningProject::find($enrollment->learning_project);
                if ($project) {
                    $enrollmentModel->learning_project()->associate($project);
                }
            }

            return $enrollmentModel->save();
        } catch (\Throwable $th) {
            throw new EnrollmentNotUpdateException();
        }
    }

    public function delete($id): void
    {
        try {
            $enrollmentModel = Enrollment::find($id);
            if ($enrollmentModel) {
                throw new EnrollmentNotExistException();
            }

            $enrollmentModel->delete();
        } catch (\Throwable $th) {
            throw new EnrollmentNotDeleteException();
        }
    }

	protected function transformToDTO(Model $model): DTOSummary
    {
        return new EnrollmentDTO(
            id: $model->id,
            school_year: $model->school_year,
            school_moment: $model->school_moment,
            degree: $model->degree,
            section: $model->section,
            classroom: $model->classroom,
            teacher_id: $model->teacher_id,
        );
    }
}
