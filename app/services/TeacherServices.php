<?php 

namespace App\services;

use App\Constants\RoleConstants;
use App\DTOs\TeacherDTO;
use App\Repositories\Interfaces\TeacherInterface;
use Spatie\Permission\Models\Role;

class TeacherServices {

    public function __construct(
        private TeacherInterface $teacherRepository
    ){}

    public function createTeacher(TeacherDTO $teacherDTO)
    {
        $this->teacherRepository->create($teacherDTO);
    }

    public function updateTeacher(TeacherDTO $teacherDTO) 
    {
        $this->teacherRepository->update($teacherDTO);
    }

    public function findTeacher(int $id): TeacherDTO
    {
        return $this->teacherRepository->find($id);
    }

    public function deleteTeacher(int $id)
    {
        $this->teacherRepository->delete($id);
    }
}