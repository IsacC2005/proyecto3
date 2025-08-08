<?php 


namespace App\Repositories\Interfaces;

use App\DTOs\Summary\RepresentativeDTO;

interface RepresentativeInterface {

    public function create(RepresentativeDTO $representative): RepresentativeDTO;

    public function find($id): RepresentativeDTO;

    public function findAll(): array;

    public function findByStudent(int $student_id): array;

    public function findByName($name): array;

    public function update(RepresentativeDTO $representative): RepresentativeDTO;

    public function delete($id): void;
}
?>