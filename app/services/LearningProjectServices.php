<?php

namespace App\Services;

use App\Constants\TDTO;
use App\DTOs\Details\LearningProjectDetailDTO;
use App\DTOs\Summary\LearningProjectDTO;
use App\Exceptions\LearningProject\LearningProjectNotCreatedException;
use App\Exceptions\LearningProject\LearningProjectNotFindException;
use App\Repositories\Interfaces\EnrollmentInterface;
use App\Repositories\Interfaces\LearningProjectInterface;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LearningProjectServices
{
    public function __construct(
        private LearningProjectInterface $projectRepository,
        private EnrollmentInterface $enrollmentRepository,
        private DailyClassServices $dailyClassServices,
        private DatesActual $datesActual
    ) {}



    public function createProject(LearningProjectDetailDTO $data)
    {
        try {
            $project = $this->projectRepository->create($data);

            foreach ($data->getDailyClasses() as $class) {
                $class->learningProjectId = $project->id;
                $this->dailyClassServices->createDailyClass($class);
            }
            return redirect()->route('learning-project.index')->with('flash', [
                'alert' => [
                    'title' => '¡Exito!',
                    'description' => 'El proyecto ya se a creado ahora puedes agregar Referentes teoricos y evaluarlos',
                    'message' => 'El proyecto de aprendizaje se creo correctamente :)',
                    'code' => '200'
                ]
            ]);
        } catch (\Throwable $th) {
            $this->projectRepository->delete($project->id);
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

    public function findByTeacher(): array
    {
        $user = Auth::user();
        if ($user->userable_type === 'App\Models\Teacher') {
            $teacher = $user->userable;
        } else {
            return [];
        }

        return $this->projectRepository->findByTeacher($teacher->id ? $teacher->id : 0, TDTO::DETAIL);
    }


    public function findByEnrollment(int $enrollmentId, int $teacherId)
    {

        $assingEnrollmentTeacher = $this->enrollmentRepository->teacherItsAssing($enrollmentId, $teacherId);

        if (!$assingEnrollmentTeacher) {
            throw new LearningProjectNotFindException("Este Profesor no tiene asignado esta matricula", 422);
        }

        $rs = $this->projectRepository->findByEnrollment($enrollmentId);

        return Inertia::render('LearningProject/CreateLearningProject', [
            'exist' => $rs ? true : false,
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

    public function updateProject(LearningProjectDTO $project)
    {
        $project = $this->projectRepository->update($project);
    }

    public function deleteProject(int $id) {}
}
