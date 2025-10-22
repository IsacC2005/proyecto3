<?php


namespace App\Repositories;

use App\Constants\TDTO;
use App\DTOs\PaginationDTO;
use App\DTOs\Summary\StudentDTO;
use App\Exceptions\DailyClass\DailyClassNotExistException;
use App\Exceptions\Representative\RepresentativeNotExistException;
use App\Exceptions\Student\StudentNotDeleteException;
use App\Exceptions\Student\StudentNotExistException;
use App\Exceptions\Student\StudentNotFindException;
use App\Exceptions\Student\StudentNotFindInTheEnrollmentException;
use App\Exceptions\Student\StudentNotUpdateException;
use App\Exceptions\StudentNotCreatedException;
use App\Models\DailyClass;
use App\Models\Enrollment;
use App\Models\Representative;
use App\Models\Student;
use App\Repositories\Interfaces\StudentInterface;
use App\Repositories\TransformDTOs\TransformDTOs;
use App\DTOs\Summary\DTOSummary;
use Illuminate\Database\Eloquent\Model;
use App\DTOs\Details\DTODetail;
use App\Models\LearningProject;

class StudentRepository extends TransformDTOs implements StudentInterface
{

    public function createStudent(StudentDTO $student): StudentDTO
    {
        try {

            $studentModel = Student::create([
                'grade' => $student->grade,
                'name' => $student->name,
                'surname' => $student->surname
            ]);

            if (!$studentModel) {
                throw new StudentNotCreatedException();
            }
            return $this->transformToDTO($studentModel);
        } catch (\Throwable $th) {
            throw $th;
        }
    }



    public function findStudentById($id): StudentDTO
    {
        try {
            $studentModel = Student::find($id);
            if (!$studentModel) {
                throw new StudentNotFindException();
            }
            return $this->transformToDTO($studentModel);
        } catch (\Throwable $th) {
            throw new StudentNotFindException();
        }
    }



    public function findAllStudent(?string $fn = TDTO::SUMMARY): PaginationDTO
    {
        try {
            $studentModels = Student::orderBy('created_at', 'desc')->paginate(10);

            if (!$studentModels) {
                throw new StudentNotFindException();
            }
            $pagination = new PaginationDTO($studentModels);

            $data = $this->transformListDTO($studentModels->getCollection());

            $pagination->data = $data;
            return $pagination;
        } catch (\Throwable $th) {
            throw $th;
        }
    }



    public function findStudentByName($name): StudentDTO
    {
        try {
            $student = Student::where('name', $name)->first();
            if (!$student) {
                throw new StudentNotFindException();
            }

            return $this->transformToDTO($student);
        } catch (\Throwable $th) {
            throw new StudentNotFindException();
        }
    }



    public function findStudentByEnrollment(int $enrollmentId): array
    {

        try {
            $enrollment = Enrollment::find($enrollmentId);
            if (!$enrollment) {
                throw new StudentNotFindInTheEnrollmentException();
            }

            $students = Student::whereHas('enrollments', function ($query) use ($enrollmentId) {
                $query->where('id', $enrollmentId);
            })->get();

            return $this->transformListDTO($students);
        } catch (\Throwable $th) {
            throw new StudentNotFindInTheEnrollmentException();
        }
    }



    public function findStudentByGrade(int $grade, ?bool $NotAddEnrollment = false, ?int $enrollmentId = null): PaginationDTO
    {
        try {
            if ($NotAddEnrollment) {
                $studentModels = Student::where('grade', $grade)
                    ->whereDoesntHave('enrollments', function ($query) use ($grade, $enrollmentId) {
                        $query->where('grade', $grade + 1)->whereNot('id', $enrollmentId);
                    })
                    ->orderBy('created_at', 'desc')
                    ->paginate(10)
                    ->withQueryString();
            } else {
                $studentModels = Student::where('grade', $grade)->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
            }
            if (!$studentModels) {
                throw new StudentNotFindException();
            }
            $pagination = new PaginationDTO($studentModels);

            $data = $this->transformListDTO($studentModels->getCollection());

            $pagination->data = $data;
            return $pagination;
        } catch (\Throwable $th) {
            throw $th;
        }
    }



    public function findStudentByLearningProject(int $learningProjectId): array
    {
        try {
            // $studentModels = Student::whereHas('enrollments', function ($query) use ($learningProjectId) {
            //     $query->whereHas('learning_project', function ($subQuery) use ($learningProjectId) {
            //         $subQuery->where('id', $learningProjectId);
            //     });
            // })->get();

            $studentModels = LearningProject::with('enrollment.students')->find($learningProjectId);

            if (!$studentModels) {
                throw new StudentNotFindException();
            }

            return $this->transformListDTO($studentModels->enrollment->students);
        } catch (\Throwable $th) {
            throw new StudentNotFindException($th->getMessage());
        }
    }



    public function findStudentByDailyClass(int $dailyClassId): array
    {
        try {
            $dailyClassModel = DailyClass::with('learning_project.enrollment.students')->find($dailyClassId);
            if (!$dailyClassModel | !$dailyClassModel->learning_project || !$dailyClassModel->learning_project->enrollment) {
                throw new DailyClassNotExistException();
            }

            return $this->transformListDTO($dailyClassModel->learning_project->enrollment->students);
        } catch (\Throwable $th) {
            throw new StudentNotFindException($th->getMessage());
        }
    }



    public function findStudentByRepresentative(int $representativeId): array
    {
        try {
            $representativeModel = Representative::find($representativeId)->firs();
            if (!$representativeModel) {
                throw new RepresentativeNotExistException();
            }
            $studentModels = Student::where('representative_id', $representativeId)->get();
            if ($studentModels) {
                throw new StudentNotFindException();
            }

            return $this->transformListDTO($studentModels->toArray());
        } catch (\Throwable $th) {
            throw new StudentNotFindException();
        }
    }



    public function updateStudent(StudentDTO $student): StudentDTO
    {
        try {
            $studentModel = Student::find($student->id);
            if (!$studentModel) {
                throw new StudentNotFindException();
            }

            $studentModel->name = $student->name;
            $studentModel->surname = $student->surname;

            return $studentModel->save();
        } catch (\Throwable $th) {
            throw new StudentNotUpdateException();
        }
    }



    public function deleteStudent($id): void
    {
        try {
            $studentModel = Student::find($id);
            if (!$studentModel) {
                throw new StudentNotExistException();
            }
            $studentModel->delete();
        } catch (\Throwable $th) {
            throw new StudentNotDeleteException();
        }
    }

    protected function transformToDTO(Model $model): DTOSummary
    {
        $representative = $model->representative;
        return new StudentDTO(
            id: $model->id,
            grade: $model->grade,
            name: $model->name,
            surname: $model->surname,
        );
    }

    protected function transformToDetailDTO(Model $model): DTODetail
    {
        // TODO
    }
}
