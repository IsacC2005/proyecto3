<?php


namespace App\DTOs\Summary;

class RepresentativeDTO implements DTOSummary
{

    private $studentIds = [];

    public function __construct(
        public int $id,
        public int $idcard,
        public int $phone,
        public string $name,
        public string $surname,
        public string $direction,
    ) {}

    public function addStudent(int $studentId): void
    {
        $this->studentIds[] = $studentId;
    }

    public function getStudents(): array
    {
        return $this->studentIds;
    }
}
