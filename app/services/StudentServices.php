<?php

namespace App\Services;

use App\DTOs\PaginationDTO;
use App\DTOs\Summary\StudentDTO;
use App\Repositories\Interfaces\RepresentativeInterface;
use App\Repositories\Interfaces\StudentInterface;
use App\Utilities\FlashMessage;
use Inertia\Inertia;

class StudentServices
{
    public function __construct(
        private StudentInterface $studentRepository,
        private RepresentativeInterface $representative
    ) {}


    public function pageCreateShow(?int $idcard = null)
    {
        if (!$idcard) {
            return Inertia::render('Student/CreateStudent');
        }

        $data = $this->representative->findRepresentativeByIdcard($idcard);
        if (!$data) {
            return Inertia::render(
                'Student/CreateStudent'
            )->with('flash', FlashMessage::success(
                '¡Error!',
                'Representante no entoncontrado',
                'No se encontro ningun representante con ese numero de cedula'
            ));
        }
        return Inertia::render('Student/CreateStudent', [
            'representative' => $data
        ]);
    }


    public function createStudent(StudentDTO $student): StudentDTO
    {
        return $this->studentRepository->createStudent($student);
    }



    public function findStudentById(int $id): StudentDTO
    {
        return $this->studentRepository->findStudentById($id);
    }



    public function findAllStudent(): PaginationDTO
    {
        return $this->studentRepository->findAllStudent();
    }



    public function findStudentByEnrollment(int $enrollmentId): array
    {
        return $this->findStudentByEnrollment($enrollmentId);
    }



    public function updateStudent(StudentDTO $student): StudentDTO
    {
        return $this->studentRepository->updateStudent($student);
    }

    public function deleteStudent(int $id): void
    {
        $this->studentRepository->deleteStudent($id);
    }
}
