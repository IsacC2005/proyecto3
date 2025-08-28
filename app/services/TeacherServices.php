<?php

namespace App\Services;

use App\DTOs\Summary\TeacherDTO;
use App\Constants\RoleConstants;
use App\Constants\TDTO;
use App\DTOs\PaginationDTO;
use App\Exceptions\Enrollment\EnrollmentNotFindException;
use App\Repositories\Interfaces\DailyClassInterface;
use App\Repositories\Interfaces\LearningProjectInterface;
use App\Repositories\Interfaces\TeacherInterface;
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
        $roleId = $this->roleServices->findRoleByName(RoleConstants::PROFESOR);

        $userDTO = $teacherDTO->UserDTO;

        $userDTO->roleId = $roleId->id;

        $userModel = $this->userServices->createUser($userDTO);

        $teacherDTO->userId = $userModel->id;

        $this->teacherRepository->createTeacher($teacherDTO);
    }


    public function findAll(): PaginationDTO
    {
        return $this->teacherRepository->findAll();
    }


    public function findAllNotEnrollmentPeriod(int $enrollmentId): PaginationDTO
    {
        $enrollment = $this->enrollmentServices->findEnrollment($enrollmentId);

        if (!$enrollment) {
            throw new EnrollmentNotFindException($enrollmentId);
        }

        return $this->teacherRepository->findAllNotEnrollmentAssign($enrollment->schoolYear, $enrollment->schoolMoment);
    }


    public function enrollmentsAssigns()
    {
        $id = Auth::user()->userable_id;

        $teacher = $this->teacherRepository->find($id);

        return $this->enrollmentServices->findEnrollmentByTeacher(Auth::user()->userable_id, TDTO::DETAIL);
    }



    public function evaluateShowPage()
    {
        $id = Auth::user()->userable_id;

        $teacher = $this->teacherRepository->find($id);

        $enrollment = $this->enrollmentServices->findEnrollmentActiveByTeacher($id);

        $learningProject = $this->projectRepository->findByEnrollment($enrollment->id);

        $dailyClasses = $this->dailyClassRepository->findByLearningProject($learningProject->id, TDTO::DETAIL);

        return Inertia::render('Teacher/EvaluateTeacher', [
            'evaluations' => $dailyClasses
        ]);
    }


    public function listStudentsEvaluate(int $classId) {}


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
