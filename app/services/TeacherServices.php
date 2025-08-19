<?php

namespace App\Services;

use App\DTOs\Summary\TeacherDTO;
use App\DTOs\Summary\UserDTO;
use App\Constants\RoleConstants;
use App\DTOs\PaginationDTO;
use App\Repositories\Interfaces\TeacherInterface;

class TeacherServices
{

    public function __construct(
        private TeacherInterface $teacherRepository,
        private UserServices $userServices,
        private RoleServices $roleServices
    ) {}



    public function createTeacher(TeacherDTO $teacherDTO)
    {
        $id_role = $this->roleServices->findRoleByName(RoleConstants::PROFESOR);

        $userDTO = $teacherDTO->UserDTO;

        $userDTO->rol_id = $id_role->id;

        $userModel = $this->userServices->createUser($userDTO);

        $teacherDTO->user_id = $userModel->id;

        $this->teacherRepository->createTeacher($teacherDTO);
    }


    public function findAll(): PaginationDTO
    {
        return $this->teacherRepository->findAll();
    }


    public function updateTeacher(TeacherDTO $teacherDTO)
    {
        $result = $this->teacherRepository->update($teacherDTO);
        if (!$result) {
            return 'ALgo a fallado';
        }
        return 'update ok';
    }

    public function findTeacher(int $id): TeacherDTO
    {
        $user = $this->userServices->findByUserByUserable($id);
        $teacher = $this->teacherRepository->find($id);
        $teacher->UserDTO = $user;

        return $teacher;
    }

    public function deleteTeacher(int $id)
    {
        $this->teacherRepository->delete($id);
    }
}
