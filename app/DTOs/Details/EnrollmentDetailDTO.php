<?php

namespace App\DTOs\Details;

class EnrollmentDetailDTO implements DTODetail
{

    private $students = [];

    public function __construct(
        public int $id,
        public string $schoolYear,
        public int $grade,
        public string $section,
        public string $classroom,
        public ?TeacherDetailDTO $teacher = null,
        public ?LearningProjectDetailDTO $learningProject = null,
    ) {}

    public function addStudent(StudentDetailDTO $student): void
    {
        $this->students[] = $student;
    }

    public function getStudents(): array
    {
        return $this->students;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'schoolYear' => $this->schoolYear,
            'grade' => $this->grade,
            'section' => $this->section,
            'classrom' => $this->classroom,
            'teacher' => $this->teacher ? $this->teacher : null,
            'learningProject' => $this->learningProject ? $this->learningProject : null,
            'students' => $this->getStudents()
        ];
    }
}
