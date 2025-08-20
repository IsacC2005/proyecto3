<?php

namespace App\DTOs\Searches;

class RepresentativeSearchDTO implements DTOSearch
{
    private $student_ids = [];

    public function __construct(
        public ?int $id = null,
        public ?int $idcard = null,
        public ?int $phone = null,
        public ?string $name = null,
        public ?string $surname = null,
        public ?string $direction = null,
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
