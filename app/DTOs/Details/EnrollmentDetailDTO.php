<?php
namespace App\DTOs\Details;

class EnrollmentDetailDTO implements DTODetail
{

    private $students = [];

    public function __construct(
        public int $id,
        public string $school_year,
        public string $school_moment,
        public int $degree,
        public string $section,
        public int $classroom,
        public ?TeacherDetailDTO $teacher = null,
        public ?LearningProjectDetailDTO $learning_project = null,
    ) {}

    public function addStudent(StudentDetailDTO $student): void
    {
        $this->students[] = $student;
    }

    public function getStudents(): array
    {
        return $this->students;
    }
}
?>
