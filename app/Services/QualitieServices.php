<?php

namespace App\Services;

use App\Constants\RoleConstants;
use App\Models\LearningProjectQualiteStudent;
use App\Models\LearningProjectQualiteStudentStatus;
use App\Models\LearningProjectQualitieStudentStatus;
use App\Models\Qualitie;
use App\Models\QualitieType;
use App\Repositories\Interfaces\DailyClassInterface;
use App\Repositories\Interfaces\LearningProjectInterface;
use App\Repositories\Interfaces\StudentInterface;
use App\Repositories\Interfaces\TeacherInterface;
use App\Utilities\FlashMessage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class QualitieServices
{
    public function __construct(
        private StudentInterface $studentRepository,
        private DailyClassInterface $dailyClassRepository,
        private TeacherInterface $teacherRepository,

        private EnrollmentServices $enrollmentServices,
        private DatesActual $datesActual,
        private LearningProjectInterface $projectRepository
    ) {}

    public function showPageEvaluate(int $ProjectId): InertiaResponse | RedirectResponse
    {
        $user = Auth::user();

        $id = $user->userable_id;

        $existTeacher = $this->teacherRepository->existTeacher($id);

        if (!$user->hasRole(RoleConstants::PROFESOR) || !$existTeacher) {
            throw new \ErrorException();
        }

        // $enrollment = $this->enrollmentServices->findEnrollmentActiveByTeacher($id);

        // if (!$enrollment) {
        //     activity('Seccion no encontrada')
        //         ->causedBy($user)
        //         ->log("Se intento acceder a la vista de evaluacion de cualidades de los estudiantes pero no se encontro una seccion actual");

        //     return redirect()->route('dashboard')
        //         ->with('flash', FlashMessage::error(
        //             'Seccion no encontrada',
        //             'No tienes una seccion actual asignada',
        //             'Para evaluar las cualidades de los estudiantes necesitas un proyecto en una seccion actual'
        //         ));
        // }

        // $moment = $this->datesActual->getSchoolMomentActual();
        $learningProject = $this->projectRepository->find($ProjectId);

        if (!$learningProject) {
            activity('Proyecto no encontrado')
                ->causedBy($user)
                ->log("Se intento buscar un proyecto de aprendizaje pero no se encontro");

            return redirect()->route('dashboard')
                ->with('flash', FlashMessage::error(
                    'Proyecto no encontrado',
                    'No se encontró un proyecto de aprendizaje para la sección actual',
                    'Para evaluar las cualidades de los estudiantes necesitas un proyecto de aprendizaje en la sección actual'
                ));
        }

        $students = $this->studentRepository->findStudentByLearningProject($learningProject->id);


        ///

        $learningProjectId = $learningProject->id;

        $qualities = QualitieType::with('qualities')->get();

        $rawNotes = LearningProjectQualiteStudent::where('learning_project_id', $learningProjectId)
            ->select('student_id', 'qualitie_id')
            ->get();

        $allNote = $rawNotes->groupBy('student_id')->map(function ($group) {
            return $group->pluck('qualitie_id')->toArray();
        });

        $rawEvaluatedStatus = LearningProjectQualitieStudentStatus::select('student_id', 'status')
            ->where('learning_project_id', $learningProjectId)
            ->get();

        $allEvaluatedStatus = $rawEvaluatedStatus->pluck('status', 'student_id')->map(function ($status) {
            return (bool) $status;
        })->toArray();


        return Inertia::render('Qualitie/EvaluateQualitie', [
            'students' => $students,
            'qualities' => $qualities,
            'learningProjectId' => $ProjectId,
            'allNote' => $allNote,
            'allEvaluatedStatus' => $allEvaluatedStatus
        ]);
    }

    /**
     *
     * @param int $projectId
     * @return void
     */
    public function evaluateRandomToProject(int $projectId): void
    {
        $project = $this->projectRepository->find($projectId);
        if (!$project) {
            return;
        }

        $students = $this->studentRepository->findStudentByLearningProject($projectId);
        $allQualities = Qualitie::all()->pluck('id');

        if ($allQualities->isEmpty()) {
            return;
        }

        foreach ($students as $student) {
            $numberOfQualities = rand(4, 5);
            $randomQualities = $allQualities->random($numberOfQualities)->unique();

            foreach ($randomQualities as $qualityId) {
                LearningProjectQualiteStudent::create([
                    'student_id' => $student->id,
                    'learning_project_id' => $projectId,
                    'qualitie_id' => $qualityId,
                ]);
            }
        }
    }
}
