<?php


namespace App\DTOs\Details;

class RepresentativeDetailDTO implements DTODetail
{

    private $students = [];

    public function __construct(
        public int $id,
        public int $idcard,
        public int $phone,
        public string $name,
        public string $surname,
        public string $direction,
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
