<?php


namespace App\Repositories;

use App\DTOs\EnrollmentDTO;
use App\DTOs\StudentDTO;
use App\Models\DailyClass;
use App\Models\Enrollment;
use App\Models\LearningProject;
use App\Models\Student;
use App\Repositories\interfaces\StudentInterface;
use App\Repositories\Traits\StudentTrait;

class StudentRepository implements StudentInterface
{

    use StudentTrait;

	public function create(StudentDTO $student): bool 
    {
        $studentModel = Student::create([
            'name' => $student->name,
            'surname' => $student->surname,
        ]);

        if(!$studentModel) {
            return false;
        }
        return true;
    }



    public function find($id): StudentDTO | null 
    {
        $student = Student::find($id);
        if (!$student) {
            return null;
        }

        return $this->transformToDTO($student);
    }



    public function findAll(): array 
    {
        $students = Student::all();
        return $this->transformListDTO($students->toArray());
    }



    public function findByName($name): StudentDTO | null
    {
        $student = Student::where('name', $name)->first();
        if (!$student) {
            return null;
        }

        return $this->transformToDTO($student);
    }



    public function findByEnrollment(int $enrollment_id): array 
    {

        $enrollment = Enrollment::find($enrollment_id);
        if (!$enrollment) {
            return [];
        }

        $students = Student::whereHas('enrollments', function ($query) use ($enrollment_id) {
            $query->where('id', $enrollment_id);
        })->get();
        
        return $this->transformListDTO($students->toArray());
    }



    public function findByLearningProject(int $learning_project_id): array
    {
        $students = Student::whereHas('enrollments', function ($query) use ($learning_project_id) {
            $query->whereHas('learning_project', function($subQuery) use ($learning_project_id) {
                $subQuery->where('id', $learning_project_id);
            });
        })->get();

        return $this->transformListDTO($students->toArray());
    }

	public function findByDailyClass(int $daily_class_id): array 
    {
        $dailyClassModel = DailyClass::find($daily_class_id);
        if (!$dailyClassModel) {
            return [];
        }
        $id = $dailyClassModel->learning_project_id;
        $students = Student::whereHas('enrollments', function ($query) use ($id) {
            $query->whereHas('learning_project', function ($subQuery) use ($id) {
                $subQuery->where('id', $id);
            });
        })->get();

        return $this->transformListDTO($students->toArray());
    }

	public function findByRepresentative(int $representative_id): array 
    {
        $students = Student::where('representative_id', $representative_id)->get();
        return $this->transformListDTO($students->toArray());
    }

	public function update(StudentDTO $student): bool 
    {
        $studentModel = Student::find($student->id);
        if (!$studentModel) {
            return false;
        }

        $studentModel->name = $student->name;
        $studentModel->surname = $student->surname;

        return $studentModel->save();
    }



    public function delete($id): bool 
    {
        $studentModel = Student::find($id);
        if (!$studentModel) {
            return false;
        }
        return $studentModel->delete();
    }
}
?>