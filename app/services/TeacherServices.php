<?php

namespace App\Services;

use App\DTOs\Summary\TeacherDTO;
use App\DTOs\Summary\UserDTO;
use App\Constants\RoleConstants;
use App\DTOs\PaginationDTO;
use App\Exceptions\Enrollment\EnrollmentNotFindException;
use App\Exceptions\Teacher\TeacherNotFindException;
use App\Repositories\Interfaces\DailyClassInterface;
use App\Repositories\Interfaces\LearningProjectInterface;
use App\Repositories\Interfaces\TeacherInterface;
use Dotenv\Parser\Entry;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TeacherServices
{

    public function __construct(
        private TeacherInterface $teacherRepository,
        private EnrollmentServices $enrollmentServices,
        private UserServices $userServices,
        private RoleServices $roleServices,
        private LearningProjectInterface $projectRepository,
        private DailyClassInterface $dailyClassRepository
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


    public function findAllNotEnrollmentPeriod(int $enrollment_id): PaginationDTO
    {
        $enrollment = $this->enrollmentServices->findEnrollment($enrollment_id);

        if (!$enrollment) {
            throw new EnrollmentNotFindException($enrollment_id);
        }

        return $this->teacherRepository->findAllNotEnrollmentAssign($enrollment->school_year, $enrollment->school_moment);
    }


    public function enrollmentsAssigns()
    {
        $id = Auth::user()->userable_id;

        $teacher = $this->teacherRepository->find($id);

        return $this->enrollmentServices->findEnrollmentByTeacher(Auth::user()->userable_id, 'transformToDetailDTO');
    }



    public function evaluateShowPage()
    {
        $id = Auth::user()->userable_id;

        $teacher = $this->teacherRepository->find($id);

        $enrollment = $this->enrollmentServices->findEnrollmentActiveByTeacher($id);

        $learningProject = $this->projectRepository->findByEnrollment($enrollment->id);

        $dailyClasses = $this->dailyClassRepository->findByLearningProject($learningProject->id);

        return Inertia::render('Teacher/EvaluateTeacher', [
            'evaluations' => $dailyClasses
        ]);
    }


    public function listStudentsEvaluate(int $class_id) {}


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
