<?php

namespace App\Services;

use App\DTOs\PaginationDTO;
use App\DTOs\Summary\StudentDTO;
use App\Repositories\Interfaces\StudentInterface;
use Inertia\Inertia;

use function PHPUnit\Framework\isNumeric;

class StudentServices {
    public function __construct(
        private StudentInterface $studentRepository,
        private RepresentativeServices $representativeServices
    ){}


    public function pageCreateShow(?int $idcard = null)
    {
        if(!$idcard){
            return Inertia::render('Student/CreateStudent');
        }

        $data = $this->representativeServices->findRepresentativeByIdcard($idcard);
        return Inertia::render('Student/CreateStudent', [
            'representative' => $data
        ]);
}


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
