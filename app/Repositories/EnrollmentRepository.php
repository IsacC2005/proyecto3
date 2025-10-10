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
use App\DTOs\Details\DTODetail;
use App\DTOs\Details\EnrollmentDetailDTO;
use App\Exceptions\Teacher\TeacherNotExistException;
use App\Factories\TeacherFactory;
use App\Factories\LearningProjectFactory;
use App\Factories\StudentFactory;

class EnrollmentRepository extends TransformDTOs implements EnrollmentInterface
{

    public function __construct(
        private TeacherRepository $teacherRepository,
        private LearningProjectRepository $learningProjectRepository
    ) {}


    public function create(EnrollmentDTO $enrollment): EnrollmentDTO
    {

        try {
            $enrollmentModel = Enrollment::create([
                'school_year' => $enrollment->schoolYear,
                'school_moment' => $enrollment->schoolMoment,
                'grade' => $enrollment->grade,
                'section' => $enrollment->section,
                'classroom' => $enrollment->classroom,
                'teacher_id' => $enrollment->teacherId,
            ]);

            if (!$enrollmentModel) {
                throw new EnrollmentNotCreatedException();
            }

            return $this->transformToDTO($enrollmentModel);
        } catch (\Throwable $th) {
            throw $th;
        }
    }



    public function assignTeacher(int $enrollmentId, int $teacherId): bool
    {
        try {
            $enrollment = Enrollment::find($enrollmentId);
            if (!$enrollment) {
                throw new EnrollmentNotExistException();
            }

            $teacher = Teacher::find($teacherId);
            if (!$teacher) {
                throw new TeacherNotExistException();
            }

            $enrollment->teacher_id = $teacherId;

            return $enrollment->save();
        } catch (\Throwable $th) {
            throw $th;
        }
    }



    public function teacherItsAssing(int $enrollmentId, int $teacherId): bool
    {
        $enrollment = Enrollment::find($enrollmentId);

        if ($enrollment->teacher->id === $teacherId) {
            return true;
        }
        return false;
    }



    public function addStudent(int $enrollmentId, int $studentId): bool
    {
        try {
            $enrollment = Enrollment::find($enrollmentId);

            if (!$enrollment) {
                throw new EnrollmentNotFindException();
            }

            $enrollment->students()->syncWithoutDetaching([$studentId]);

            return $enrollment->save();
        } catch (\Throwable $th) {
            throw $th;
        }
    }



    public function studentItsAdd(int $enrollmentId, int $studentId): bool
    {
        return true;
    }



    public function studentItsAddInGrade(int $grade, int $studentId): bool
    {
        $exists = Enrollment::where('grade', $grade)->whereHas('students', function ($query) use ($studentId) {
            $query->where('student_id', $studentId);
        })->exists();

        return $exists;
    }


    public function find(int $id, ?string $fn = null): EnrollmentDTO
    {
        try {
            $enrollmentModel = Enrollment::find($id);
            if (!$enrollmentModel) {
                throw new EnrollmentNotFindException();
            }

            return $this->transformToDTO($enrollmentModel, $fn);
        } catch (\Throwable $th) {
            throw new EnrollmentNotFindException();
        }
    }



    public function findAll(?String $f = null): array
    {
        try {
            $enrollmentModel = Enrollment::all();

            if (!$enrollmentModel) {
                throw new EnrollmentNotFindException();
            }

            return $this->transformListDTO($enrollmentModel, $f);
        } catch (\Throwable $th) {
            throw  $th;
        }
    }



    public function findByYearSchool(String $year, ?string $fn = null): array
    {
        $enrollmentModel = Enrollment::where('school_year', $year)->get();

        return $this->transformListDTO($enrollmentModel, $fn);
    }



    public function findByTeacher(int $teacherId, ?String $f = null): array
    {
        try {
            $enrollments = Enrollment::where('teacher_id', $teacherId)->get();
            if (!$enrollments) {
                throw new EnrollmentNotFindException();
            }
            return $this->transformListDTO($enrollments, $f);
        } catch (\Throwable $th) {
            throw new EnrollmentNotFindException($th->getMessage());
        }
    }




    public function findByStudent(int $studentId): array
    {
        try {
            $studentModel = Student::find($studentId);
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



    public function findByLearningProject(int $learningProjectId): EnrollmentDTO
    {
        try {
            $project = LearningProject::find($learningProjectId);
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



    public function findEnrollmentOnSchoolYearByTeacher(int $teacherId, string $schoolYear): array
    {
        $enrollmentModel = Enrollment::where('school_year', $schoolYear)
            ->where('teacher_id', $teacherId)
            ->get();

        return $this->transformListDTO($enrollmentModel);
    }



    public function findEnrollmentOnSchoolYearAndSchoolMomentByTeacher(int $teacherId, string $schoolYear, int $schoolMoment): EnrollmentDTO | null
    {
        $enrollmentModel = Enrollment::where('school_year', $schoolYear)
            ->where('school_moment', $schoolMoment)
            ->where('teacher_id', $teacherId)->first();

        if (!$enrollmentModel) {
            return null;
        }

        return $this->transformToDTO($enrollmentModel);
    }




    public function existEnrollmentSecctionAndSchoolYear(int $grade, string $section, int $moment, string $year): bool
    {
        return Enrollment::where('grade', $grade)
            ->where('section', $section)
            ->where('school_moment', $moment)
            ->where('school_year', $year)->exists();
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

            $enrollmentModel->school_year = $enrollment->schoolYear;
            $enrollmentModel->school_moment = $enrollment->schoolMoment;
            $enrollmentModel->section = $enrollment->section;
            $enrollmentModel->clasroom = $enrollment->classroom;

            if ($enrollment->teacherId) {
                $teacher = Teacher::find($enrollment->teacherId);
                if ($teacher) {
                    $enrollmentModel->teacher()->associate($teacher);
                }
            }

            if ($enrollment->learningProjectId) {
                $project = LearningProject::find($enrollment->learningProjectId);
                if ($project) {
                    $enrollmentModel->learning_project()->associate($project);
                }
            }

            return $enrollmentModel->save();
        } catch (\Throwable $th) {
            throw new EnrollmentNotUpdateException();
        }
    }

    public function delete(int $id): void
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
        $enrollment = new EnrollmentDTO(
            id: $model->id,
            schoolYear: $model->school_year,
            schoolMoment: $model->school_moment,
            grade: $model->grade,
            section: $model->section,
            classroom: $model->classroom,
            teacherId: $model->teacher_id,
        );

        if ($model->students) {
            foreach ($model->students as $student) {
                $enrollment->addStudent($student->id);
            }
        }
        return $enrollment;
    }

    protected function transformToDetailDTO(Model $model): DTODetail
    {
        $enrollment = new EnrollmentDetailDTO(
            id: $model->id,
            schoolYear: $model->school_year,
            schoolMoment: $model->school_moment,
            grade: $model->grade,
            section: $model->section,
            classroom: $model->classroom,
            teacher: $model->teacher ? TeacherFactory::fromArrayDetail(['id' => $model->teacher->id, 'name' => $model->teacher->name, 'surname' => $model->teacher->surname, 'phone' => $model->teacher->phone]) : null,
            learningProject: $model->learning_project ? LearningProjectFactory::fromArrayDetail(['id' => $model->learning_project->id, 'title' => $model->learning_project->title]) : null
        );

        if ($model->students) {
            foreach ($model->students as $student) {
                $enrollment->addStudent(StudentFactory::fromArrayDetail([
                    'id' => $student->id,
                    'grade' => $student->grade,
                    'name' => $student->name,
                    'surname' => $student->surname
                ]));
            }
        }

        return $enrollment;
    }
}
