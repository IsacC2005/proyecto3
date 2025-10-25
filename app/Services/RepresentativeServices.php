<?php

namespace App\Services;

use App\DTOs\PaginationDTO;
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


    public function findAll(): PaginationDTO
    {
        return $this->representativeRepository->findAll();
    }



    public function findRepresentativeByIdcard(int $idcard): RepresentativeDTO
    {
        return $this->representativeRepository->findRepresentativeByIdcard($idcard);
    }



    public function findRepresentativeByStudent(int $studentId): RepresentativeDTO
    {
        return $this->representativeRepository->findRepresentativeByStudent($studentId);
    }



    public function findRepresentativeByEnrollment(int $enrollmentId): array
    {
        return $this->representativeRepository->findRepresentativeByEnrollment($enrollmentId);
    }



    public function updateRepresentative(RepresentativeDTO $representative): RepresentativeDTO
    {
        return $this->representativeRepository->updateRepresentative($representative);
    }



    public function deleteRepresentative(int $id): void
    {
        $this->representativeRepository->deleteRepresentative($id);
    }
}
