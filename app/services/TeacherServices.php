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
use App\Utilities\FlashMessage;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TeacherServices
{

    public function __construct(
        private TeacherInterface $teacherRepository,
        private EnrollmentServices $enrollmentServices,
        private UserServices $userServices,
        private RoleServices $roleServices,
        //repositories adicionales
        private LearningProjectInterface $projectRepository,
        private DailyClassInterface $dailyClassRepository,
        //
        private DatesActual $datesActual
    ) {}



    public function createTeacher(TeacherDTO $teacherDTO)
    {
        $roleId = $this->roleServices->findRoleByName(RoleConstants::PROFESOR);

        $userDTO = $teacherDTO->UserDTO;

        $userDTO->roleId = $roleId->id;

        $userModel = $this->userServices->createUser($userDTO);

        // $teacherDTO->userId = $userModel->id;

        // $this->teacherRepository->createTeacher($teacherDTO);

        return redirect()->route('teacher.index')->with('flash', [
            'alert' => [
                'title' => '¡Exito!',
                'description' => 'Profesor Creado',
                'message' => 'El profesor se a creado correctamente ahora puede acceder con los datos creados',
                'code' => '200'
            ]
        ]);
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
        $user = Auth::user();

        //throw new \ErrorException($user->userable());
        $id = $user->userable_id;

        $teacher = $this->teacherRepository->find($id);

        $enrollment = $this->enrollmentServices->findEnrollmentActiveByTeacher($id);

        $moment = $this->datesActual->getSchoolMomentActual();

        $learningProject = $this->projectRepository->findByEnrollmentAndMoment($enrollment->id, $moment);

        if (!$learningProject) {
            return redirect()->route('dashboard')->with(
                'flash',
                FlashMessage::success(
                    'Sin proyecto de aprendizaje',
                    'No existe un proyecto de aprendizaje actual para evaluar.',
                    'Por favor, cree un proyecto de aprendizaje antes de continuar con la evaluación.',
                )
            );
        }

        $dailyClasses = $this->dailyClassRepository->findByLearningProject($learningProject->id, TDTO::DETAIL);

        return Inertia::render('Teacher/EvaluateTeacher', [
            'evaluations' => $dailyClasses,
            'project' => $learningProject
        ]);
    }


    public function listStudentsEvaluate(int $classId) {}


    public function updateTeacher(TeacherDTO $teacherDTO)
    {
        $result = $this->teacherRepository->update($teacherDTO);
        if (!$result) {
            return 'ALgo a fallado';
        }
        return redirect()->route('teacher.index')->with(
            'flash',
            FlashMessage::success(
                '¡Exito!',
                'Profesor actualizado',
                'El profesor se actualizo sin problemas'
            )
        );
    }

    public function findTeacher(int $id): TeacherDTO
    {
        $user = $this->userServices->findByUserByUserable($id);
        $teacher = $this->teacherRepository->find($id);
        $teacher->user = $user;

        return $teacher;
    }

    public function deleteTeacher(int $id)
    {
        $this->teacherRepository->delete($id);
    }
}
