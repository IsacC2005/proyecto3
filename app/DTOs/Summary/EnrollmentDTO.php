<?php

namespace App\DTOs\Summary;

class EnrollmentDTO implements DTOSummary
{

    private $studentIds = [];

    public function __construct(
        public int $id,
        public string $schoolYear,
        public int $grade,
        public string $section,
        public string $classroom,
        public ?int $teacherId = 0,
        public ?int $learningProjectId = null,
    ) {}

    public function addStudent(int $studentId): void
    {
        $this->studentIds[] = $studentId;
    }

    public function getStudents(): array
    {
        return $this->studentIds;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'schoolYear' => $this->schoolYear,
            'grade' => $this->grade,
            'section' => $this->section,
            'classroom' => $this->classroom,
            'teacherId' => $this->teacherId,
            'learningProjectId' => $this->learningProjectId,
            'students' => $this->getStudents(),
        ];
    }
}
