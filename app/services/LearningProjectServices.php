<?php

namespace App\Services;

use App\Constants\RoleConstants;
use App\Constants\TDTO;
use App\DTOs\Details\LearningProjectDetailDTO;
use App\DTOs\Summary\LearningProjectDTO;
use App\Exceptions\LearningProject\LearningProjectNotCreatedException;
use App\Exceptions\LearningProject\LearningProjectNotFindException;
use App\Repositories\Interfaces\EnrollmentInterface;
use App\Repositories\Interfaces\LearningProjectInterface;
use App\Utilities\FlashMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class LearningProjectServices
{
    public function __construct(
        private LearningProjectInterface $projectRepository,
        private EnrollmentInterface $enrollmentRepository,
        private DailyClassServices $dailyClassServices,
        private DatesActual $datesActual
    ) {}



    public function storeProject(LearningProjectDetailDTO $data)
    {
        try {
            $exist = $this->projectRepository->existProjectByTeacheByYearByMoment(
                $data->teacher->id,
                $data->enrollment->id,
                $data->schoolMoment
            );
            if ($exist) {
                return redirect()->route('dashboard')->with('flash', [
                    'alert' => [
                        'title' => 'Error!',
                        'description' => 'El proyecto ya existe',
                        'message' => "Ya existe un proyecto de aprendizaje para esta seccion en el momento {$data->schoolMoment}",
                        'code' => '200'
                    ]
                ]);
            }
            DB::transaction(function () use ($data) {
                $project = $this->projectRepository->create($data);

                foreach ($data->getDailyClasses() as $class) {
                    $class->learningProjectId = $project->id;
                    $this->dailyClassServices->createDailyClass($class);
                }
            });
            return redirect()->route('learning-project.index')->with('flash', [
                'alert' => [
                    'title' => '¡Exito!',
                    'description' => 'El proyecto ya se a creado ahora puedes agregar Referentes teoricos y evaluarlos',
                    'message' => 'El proyecto de aprendizaje se creo correctamente :)',
                    'code' => '200'
                ]
            ]);
        } catch (\Throwable $th) {
            throw new LearningProjectNotCreatedException($th->getMessage());
        }
    }


    public function findById(int $id)
    {
        $user = Auth::user();

        $result = $this->projectRepository->existProjectForTeacher($id, $user->userable_id);

        if (!$result) {
            throw new LearningProjectNotFindException('Crack este no es tu proyecto XD no sea sapo');
        }

        $project = $this->projectRepository->find($id, TDTO::DETAIL);

        return $project;
    }

    public function findByTeacher()
    {
        $user = Auth::user();

        if (!$user->hasRole(RoleConstants::PROFESOR)) {
            return redirect()->route('dashboard')->with(
                'flash',
                FlashMessage::error(
                    'No se pueden mostrar proyectos porque su usuario no es de tipo profesor.',
                    'Acceso restringido',
                    'Solo los usuarios con rol de profesor pueden ver los proyectos de aprendizaje.'
                )
            );
        }

        $teacher_id = $user->userable_id;

        $data = $this->projectRepository->findByTeacher($teacher_id ? $teacher_id : 0, TDTO::DETAIL);

        return Inertia::render('LearningProject/ListLearningProjects', [
            'projects' => array_map(function ($aux) {
                return $aux->toArray();
            }, $data)
        ]);
    }


    public function findByEnrollment(int $enrollmentId, int $teacherId)
    {
        $assingEnrollmentTeacher = $this->enrollmentRepository->teacherItsAssing($enrollmentId, $teacherId);

        if (!$assingEnrollmentTeacher) {
            throw new LearningProjectNotFindException("Este Profesor no tiene asignado esta matricula", 422);
        }

        $projects = $this->projectRepository->findByEnrollment($enrollmentId);

        return Inertia::render('LearningProject/CreateLearningProject', [
            'projects' =>  $projects,
            'teacherId' => $teacherId,
            'enrollmentId' => $enrollmentId
        ]);
    }

    public function findActived()
    {
        $teacher_id = Auth::user()->userable->id;



        if (!$teacher_id) {
            $teacher_id = -1;
        }

        $year = $this->datesActual->getSchoolYearActual();
        $moment = $this->datesActual->getSchoolMomentActual();

        $project = $this->projectRepository->findOnDate($year, $moment, $teacher_id, TDTO::DETAIL);

        if (!$project) {
            return Inertia::render('Dashboard');
        }

        return Inertia::render(
            'LearningProject/ShowLearninProject',

            [
                'project' => $project,
                'newClass' => true
            ]
        );
    }

    public function getAllProjects() {}

    public function findProjectById(int $id) {}


    public function Notes(?int $projectId = null)
    {
        if (!$projectId) {
        }
        $user =  Auth::user();

        if (!$user->hasRole(RoleConstants::PROFESOR)) {
            throw new \ErrorException("Este usuario no es un profesor");
        }

        $teacher_id = $user->userable_id;

        if (!$teacher_id) {
            $teacher_id = -1;
        }

        $year = $this->datesActual->getSchoolYearActual();
        $moment = $this->datesActual->getSchoolMomentActual();

        $project = $this->projectRepository->findOnDate($year, $moment, $teacher_id);


        return $this->projectRepository->getAllEvaluationByProject($project->id);
    }







    public function updateProject(LearningProjectDTO $project)
    {
        $project = $this->projectRepository->update($project);
    }

    public function deleteProject(int $id) {}
}
