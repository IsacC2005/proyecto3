<?php

namespace App\Services;

use App\DTOs\Summary\TeacherDTO;
use App\Constants\RoleConstants;
use App\Constants\TDTO;
use App\DTOs\Details\TeacherDetailDTO;
use App\DTOs\PaginationDTO;
use App\DTOs\Summary\UserDTO;
use App\Exceptions\Enrollment\EnrollmentNotFindException;
use App\Models\Teacher;
use App\Models\User;
use App\Repositories\Interfaces\DailyClassInterface;
use App\Repositories\Interfaces\LearningProjectInterface;
use App\Repositories\Interfaces\TeacherInterface;
use App\Utilities\FlashMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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


    public function createUser(UserDTO $user)
    {

        DB::transaction(function () use ($user) {
            $teacher = Teacher::find($user->userable_id);

            if (!$teacher) {
                throw new  \ErrorException($user->userable_id);
            }

            $user = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'password' => bcrypt($user->password)
            ]);

            $user->userable()->associate($teacher);

            $user->save();

            $user->assignRole(RoleConstants::PROFESOR);
        });

        return redirect()->route('teacher.index')->with('flash', FlashMessage::success(
            '¡Exito!',
            "Se creo el usario de {$user->name} sin problemas",
            'Usuario creado ahora el profesor podra acceder con los datos creados'
        ));
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



    public function evaluateShowPage(?int $id = null)
    {
        $user = Auth::user();

        $teacher = $user->getTeacherEntity();

        if (!$teacher) {
            activity('Acceso restringido, se intento crear un referente teórico sin profesor asignado')
                ->causedBy($user);

            return redirect()->route('dashboard');
        }

        $enrollment = $this->enrollmentServices->findEnrollmentActiveByTeacher($teacher->id);

        $moment = $this->datesActual->getSchoolMomentActual();

        $learningProject = $this->projectRepository->findByEnrollmentAndMoment($enrollment->id ?? 0, $moment);

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

    public function findTeacher(int $id): TeacherDetailDTO
    {
        $teacher = $this->teacherRepository->find($id, TDTO::DETAIL);

        return $teacher;
    }

    public function deleteTeacher(int $id)
    {
        $this->teacherRepository->delete($id);
    }
}
