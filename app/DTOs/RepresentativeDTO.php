<?php


namespace App\DTOs;

class RepresentativeDTO
{

    private $students = [];

    public function __construct(
        public int $idcard,
        public int $phone,
        public string $name,
        public string $surname,
        public string $direction,
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