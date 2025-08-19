<?php

namespace App\Services;

use App\DTOs\PaginationDTO;
use App\DTOs\Summary\StudentDTO;
use App\Repositories\Interfaces\StudentInterface;

class StudentServices {
    public function __construct(
        private StudentInterface $studentRepository
    ){}



    public function createStudent(StudentDTO $student): StudentDTO
    {
        return $this->studentRepository->createStudent($student);
    }



    public function findStudentById(int $id): StudentDTO{
        return $this->studentRepository->findStudentById($id);
    }



    public function findAllStudent(): PaginationDTO
    {
        return $this->studentRepository->findAllStudent();
    }



    public function findStudentByEnrollment(int $enrollment_id): array{
        return $this->findStudentByEnrollment($enrollment_id);
    }



    public function updateStudent(StudentDTO $student):StudentDTO
    {
        return $this->studentRepository->updateStudent($student);
    }

    public function deleteStudent(int $id): void
    {
        $this->studentRepository->deleteStudent($id);
    }

}

?>
