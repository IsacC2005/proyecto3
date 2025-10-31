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
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

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


        $pagination = $this->projectRepository->findByTeacher($teacher_id, TDTO::DETAIL);

        /**
         * @var LearningProjectDetailDTO[]
         */
        $data = $pagination->data;

        $projectsByEnrollment = [];

        foreach ($data as $d) {
            $enrollmentId = $d->enrollment->id;

            if (!isset($projectsByEnrollment[$enrollmentId])) {
                $enrollmentArray = $d->enrollment->toArray();

                unset($enrollmentArray['teacher']);
                unset($enrollmentArray['learningProject']);
                unset($enrollmentArray['students']);

                $projectsByEnrollment[$enrollmentId] = [
                    'section' => $enrollmentArray,
                    'projects'   => []
                ];
            }
            $projectArray = $d->toArray();

            unset($projectArray['enrollment']);
            unset($projectArray['teacher']);

            // Agregar el proyecto limpio al grupo
            $projectsByEnrollment[$enrollmentId]['projects'][] = $projectArray;
        }

        // 3. Usa array_values para reindexar y eliminar las claves de ID.
        // Esto genera un array de objetos, donde cada objeto es un grupo.
        $groupedProjects = array_values($projectsByEnrollment);

        $pagination->data = $groupedProjects;


        return Inertia::render('LearningProject/ListLearningProjects', [
            'projects' => $pagination
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


    public function Notes(?int $projectId = null): Response | RedirectResponse
    {
        $user =  Auth::user();

        $project = null;

        if ($projectId) {
            $project = $this->projectRepository->find($projectId);
        } else {

            $teacher_id = $user->userable_id;

            $year = $this->datesActual->getSchoolYearActual();
            $moment = $this->datesActual->getSchoolMomentActual();

            $project = $this->projectRepository->findOnDate($year, $moment, $teacher_id);

            if (!$project) {
                activity('Proyecto no encontrado')
                    ->causedBy($user)
                    ->log('Se intento ver las notas del proyecto activo pero no se encontro.');
                return redirect()->route('dashboard')->with(
                    'flash',
                    FlashMessage::error(
                        'Error',
                        'No se encontro el proyecto',
                        "No tienes un proyecto de aprendizaje que se encuentre activo para el $year, Momento $moment."
                    )
                );
            }
        }

        $data = $this->projectRepository->getAllEvaluationByProject($project->id);

        return Inertia::render('Notes/ListNotes', [
            'data' => $data
        ]);
    }







    public function updateProject(LearningProjectDTO $project)
    {
        $project = $this->projectRepository->update($project);
    }

    public function deleteProject(int $id) {}
}
