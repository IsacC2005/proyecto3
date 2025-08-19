<?php

namespace App\Repositories\Interfaces;

use App\DTOs\Summary\TeacherDTO;
use App\DTOs\PaginationDTO;

interface TeacherInterface
{
    public function createTeacher(TeacherDTO $teacher): TeacherDTO;

    public function find($id): TeacherDTO;

    public function findByEmail($email): TeacherDTO;

    public function findAll(): PaginationDTO;

    public function findByName($name): array;

    public function update(TeacherDTO $teacher): TeacherDTO;

    public function delete($id): void;
}
