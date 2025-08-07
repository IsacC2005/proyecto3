<?php

namespace App\Repositories\interfaces;

use App\DTOs\TeacherDTO;
use App\Models\Teacher;

interface TeacherInterface
{
    public function create(TeacherDTO $teacher): TeacherDTO;

    public function find($id): TeacherDTO;

    public function findByEmail($email): TeacherDTO;

    public function findAll(): array;

    public function findByName($name): array;

    public function update(TeacherDTO $teacher): TeacherDTO;

    public function delete($id): void;
}
