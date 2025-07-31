<?php
namespace App\DTOs;

class EnrollmentDTO
{

    private $students = [];

    public function __construct(
        public int $id,
        public string $school_year,
        public string $school_moment,
        public string $section,
        public int $classroom,
        public ?TeacherDTO $teacher = null,
        public ?LearningProjectDTO $learning_project = null,
    ) {}

    public function addStudent(StudentDTO $student): void
    {
        $this->students[] = $student;
    }

    public function getStudents(): array
    {
        return $this->students;
    }
}
?>