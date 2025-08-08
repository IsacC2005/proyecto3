<?php
namespace App\DTOs\Summary;

class EnrollmentDTO
{

    private $student_ids = [];

    public function __construct(
        public int $id,
        public string $school_year,
        public string $school_moment,
        public int $degree,
        public string $section,
        public int $classroom,
        public ?int $teacher_id = 0,
        public ?int $learning_project = null,
    ) {}

    public function addStudent(int $student_id): void
    {
        $this->student_ids[] = $student_id;
    }

    public function getStudents(): array
    {
        return $this->student_ids;
    }
}
?>