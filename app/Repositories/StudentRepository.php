<?php


namespace App\Repositories;

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
use App\Repositories\interfaces\StudentInterface;
use App\Repositories\TransformDTOs\TransformDTOs;
use App\DTOs\Summary\DTOSummary;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\DTOs\Details\DTODetail;
use App\DTOs\Searches\DTOSearch;

class StudentRepository extends TransformDTOs implements StudentInterface
{

    public function createStudent(StudentDTO $student): StudentDTO
    {
        try {

            $studentModel = Student::create([
                'representative_id' => $student->representative_id,
                'degree' => $student->degree,
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



    public function findAllStudent(): PaginationDTO
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



    public function findStudentByEnrollment(int $enrollment_id): array
    {

        try {
            $enrollment = Enrollment::find($enrollment_id);
            if (!$enrollment) {
                throw new StudentNotFindInTheEnrollmentException();
            }

            $students = Student::whereHas('enrollments', function ($query) use ($enrollment_id) {
                $query->where('id', $enrollment_id);
            })->get();

            return $this->transformListDTO($students->toArray());
        } catch (\Throwable $th) {
            throw new StudentNotFindInTheEnrollmentException();
        }
    }



    public function findStudentByDegree(int $degree, ?bool $NotAddEnrollment = false): PaginationDTO
    {
        try {
            $studentModels = Student::where('degree', $degree)->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

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



    public function findStudentByLearningProject(int $learning_project_id): array
    {
        try {
            $studentModels = Student::whereHas('enrollments', function ($query) use ($learning_project_id) {
                $query->whereHas('learning_project', function ($subQuery) use ($learning_project_id) {
                    $subQuery->where('id', $learning_project_id);
                });
            })->get();

            if (!$studentModels) {
                throw new StudentNotFindException();
            }

            return $this->transformListDTO($studentModels->toArray());
        } catch (\Throwable $th) {
            throw new StudentNotFindException();
        }
    }



    public function findStudentByDailyClass(int $daily_class_id): array
    {
        try {
            $dailyClassModel = DailyClass::with('learning_project.enrollment.students')->find($daily_class_id);
            if (!$dailyClassModel | !$dailyClassModel->learning_project || !$dailyClassModel->learning_project->enrollment) {
                throw new DailyClassNotExistException();
            }

            return $this->transformListDTO($dailyClassModel->learning_project->enrollment->students);
        } catch (\Throwable $th) {
            throw new StudentNotFindException($th->getMessage());
        }
    }



    public function findStudentByRepresentative(int $representative_id): array
    {
        try {
            $representativeModel = Representative::find($representative_id)->firs();
            if (!$representativeModel) {
                throw new RepresentativeNotExistException();
            }
            $studentModels = Student::where('representative_id', $representative_id)->get();
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
            degree: $model->degree,
            name: $model->name,
            surname: $model->surname,
            representative_id: $representative->id
        );
    }

    protected function transformToDetailDTO(Model $model): DTODetail
    {
        // TODO
    }

    protected function transformToSearchDTO(Model $model): DTOSearch
    {
        // TODO
    }
}
