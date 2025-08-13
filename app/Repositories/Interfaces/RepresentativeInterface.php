<?php 


namespace App\Repositories\Interfaces;

use App\DTOs\Summary\RepresentativeDTO;

interface RepresentativeInterface {

    public function createRepresentative(RepresentativeDTO $representative): RepresentativeDTO;

    public function findRepresentativeById(int $id): RepresentativeDTO;

    public function findAllRepresentative(): array;

    public function findRepresentativeByStudent(int $student_id): RepresentativeDTO;

    public function findRepresentativeByName(String $name): array;

    public function findRepresentativeByEnrollment(int $enrollment_id): array;

    public function updateRepresentative(RepresentativeDTO $representative): RepresentativeDTO;

    public function deleteRepresentative(int $id): void;
}
?>