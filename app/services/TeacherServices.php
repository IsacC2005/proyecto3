<?php 

namespace App\services;

use App\DTOs\TeacherDTO;
use App\Repositories\Interfaces\TeacherInterface;

class TeacherServices {

    public function __construct(
        private TeacherInterface $teacherRepository
    ){}

    public function createTeacher(TeacherDTO $teacherDTO): bool
    {
        return $this->teacherRepository->create($teacherDTO);
    }

    public function updateTeacher(TeacherDTO $teacherDTO):bool 
    {
        return $this->teacherRepository->update($teacherDTO);
    }

    public function findTeacher(int $id): TeacherDTO | Null
    {
        return $this->teacherRepository->find($id);
    }

    public function deleteTeacher(int $id): bool
    {
        return $this->teacherRepository->delete($id);
    }
}