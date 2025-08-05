<?php

namespace App\Repositories\interfaces;

use App\DTOs\TeacherDTO;
use App\Models\Teacher;

interface TeacherInterface
{
    public function create(TeacherDTO $teacher): bool;

    public function find($id): TeacherDTO | null;

    public function findByEmail($email): TeacherDTO | null;

    public function findAll(): array;

    public function findByName($name): array;

    public function update(TeacherDTO $teacher): bool;

    public function delete($id): bool;
}
