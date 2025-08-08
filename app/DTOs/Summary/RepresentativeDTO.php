<?php


namespace App\DTOs\Summary;

class RepresentativeDTO
{

    private $student_ids = [];

    public function __construct(
        public int $id,
        public int $idcard,
        public int $phone,
        public string $name,
        public string $surname,
        public string $direction,
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