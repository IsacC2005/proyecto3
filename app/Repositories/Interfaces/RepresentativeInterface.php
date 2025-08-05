<?php 


namespace App\Repositories\Interfaces;

use App\DTOs\RepresentativeDTO;
use App\DTOs\StudentDTO;
use App\Models\Representative;

interface RepresentativeInterface {

    public function create(RepresentativeDTO $representative): bool;

    public function find($id): RepresentativeDTO | null;

    public function findAll(): array;

    public function findByStudent(int $student_id): array;

    public function findByName($name): array;

    public function update(RepresentativeDTO $representative): bool;

    public function delete($id): bool;
}
?>