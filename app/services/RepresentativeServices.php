<?php

namespace App\Services;

use App\DTOs\Summary\RepresentativeDTO;
use App\Repositories\Interfaces\RepresentativeInterface;

class RepresentativeServices
{
    public function __construct(
        private RepresentativeInterface $representativeRepository,
    ) {}

    public function createRepresentative(RepresentativeDTO $representative): RepresentativeDTO
    {
        return $this->representativeRepository->createRepresentative($representative);
    }



    public function findRepresentativeById(int $id): RepresentativeDTO
    {
        return $this->representativeRepository->findRepresentativeById($id);
    }



    public function findRepresentativeByIdcard(int $idcard): RepresentativeDTO
    {
        return $this->representativeRepository->findRepresentativeByIdcard($idcard );
    }



    public function findRepresentativeByStudent(int $student_id): RepresentativeDTO
    {
        return $this->representativeRepository->findRepresentativeByStudent($student_id);
    }



    public function findRepresentativeByEnrollment(int $enrollment_id): array
    {
        return $this->representativeRepository->findRepresentativeByEnrollment($enrollment_id);
    }



    public function updateRepresentative(RepresentativeDTO $representative): RepresentativeDTO
    {
        return $this->representativeRepository->updateRepresentative($representative);
    }



    public function deleteRepresentative(int $id): void{
        $this->representativeRepository->deleteRepresentative($id);
    }
}
