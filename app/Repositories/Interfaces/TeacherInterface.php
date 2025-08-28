<?php

namespace App\Repositories\Interfaces;

use App\DTOs\Summary\TeacherDTO;
use App\DTOs\PaginationDTO;

interface TeacherInterface
{
    public function createTeacher(TeacherDTO $teacher): TeacherDTO;

    public function find(int $id): TeacherDTO;

    public function findByEmail(string $email): TeacherDTO;

    public function findAll(?string $fn = null): PaginationDTO;

    public function findAllNotEnrollmentAssign(string $schoolYear, int $schoolMoment): PaginationDTO;

    public function findByName(string $name): array;

    public function update(TeacherDTO $teacher): TeacherDTO;

    public function delete(int $id): void;
}
