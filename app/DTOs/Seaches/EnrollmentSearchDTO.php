<?php
namespace App\DTOs\Searches;

class EnrollmentSearchDTO
{

    private $student_ids = [];

    public function __construct(
        public ?int $id = null,
        public ?string $school_year= null,
        public ?string $school_moment = null,
        public ?int $degree = null,
        public ?string $section = null,
        public ?int $classroom = null,
        public ?int $teacher_id = null,
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