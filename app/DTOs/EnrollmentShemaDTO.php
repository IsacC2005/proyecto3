<?php

namespace App\DTOs;

abstract class  EnrollmentShema
{

    abstract private string $student_ids;

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

    abstract public  function addStudent();

    public function getStudents(): array
    {
        return $this->student_ids;
    }
}
