<?php

namespace App\Services;

use App\Constants\RoleConstants;
use App\Constants\TDTO;
use App\DTOs\Details\DailyClassDetailDTO;
use App\DTOs\Summary\DailyClassDTO;
use App\Exceptions\DailyClass\DailyClassNotCreateException;
use App\Exceptions\LearningProject\LearningProjectNotFindException;
use App\Models\TrainingArea;
use App\Repositories\Interfaces\DailyClassInterface;
use App\Repositories\Interfaces\LearningProjectInterface;
use App\Repositories\Interfaces\TeacherInterface;
use App\Repositories\Interfaces\TrainingAreaInterface;
use App\Utilities\FlashMessage;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DailyClassServices
{



    public function __construct(
        private DailyClassInterface $dailyClassRepository,
        private LearningProjectInterface $projectRepository,
        private TrainingAreaInterface $trainingArea,
        private TeacherInterface $teacher,
        private DatesActual $datesActual
    ) {}



    public function createDailyClassShowPage(?int $id = null)
    {


        $user = Auth::user();
        $teacher = $user->getTeacherEntity();

        if (!$user->hasRole(RoleConstants::PROFESOR)) {
            activity('Acceso restringido, se intento crear un referente teórico con un usuario sin el rol requerido')
                ->causedBy($user);
            return redirect()->route('dashboard')->with(
                'flash',
                FlashMessage::error(
                    'Acceso restringido.',
                    'Acceso restringido',
                    'Solo los usuarios con rol de profesor tienen acceso a este modulo.'
                )
            );
        }

        if (!$teacher) {
            activity('Acceso restringido, se intento crear un referente teórico sin profesor asignado')
                ->causedBy($user);

            return redirect()->route('dashboard')->with(
                'flash',
                FlashMessage::success(
                    'No se puede crear el Referente Teorico.',
                    'Acceso restringido',
                    'No tienes un profesor asignado.'
                )
            );
        }

        $project = null;

        if ($id) {
            $project = $this->projectRepository->find($id);
        } else {

            $year = $this->datesActual->getSchoolYearActual();
            $moment = $this->datesActual->getSchoolMomentActual();

            $project = $this->projectRepository->findOnDate($year, $moment, $teacher->id);
        }

        if (!$project) {
            activity("Proyecto de aprendizaje no encontrado, se intento crear un referente teórico pero no se encontro ningun proyecto; Parametro id=$id")
                ->causedBy($user);

            return redirect()->route('dashboard')->with(
                'flash',
                FlashMessage::error(
                    'No se puede crear el Referente Teorico.',
                    'Proyecto de Aprendizaje no encontrado',
                    'No tienes un proyecto de aprendizaje actual para crear referentes teóricos.'
                )
            );
        }

        $trainingArea = $this->trainingArea->findAll();

        return Inertia::render(
            'DailyClass/CreateReferent',
            [
                'projectId' => $project->id,
                'trainingArea' => $trainingArea
            ]
        );
    }



    public function createDailyClass(DailyClassDTO | DailyClassDetailDTO $data)
    {

        $actual = new DateTime();

        $actual->setTime(0, 0, 0);

        $date = $data->date->setTime(0, 0, 0);

        if ($date < $actual) {
            throw new DailyClassNotCreateException(
                'No se puede asignar una fecha que ya paso',
                422
            );
        }

        $day = $date->format('N');

        if ($day > 5) {
            throw new DailyClassNotCreateException("No se puede asignar una fecha que es fin de semana", 422);
        }

        $this->dailyClassRepository->create($data);
    }



    public function findById(int $id): DailyClassDTO | DailyClassDetailDTO
    {
        return $this->dailyClassRepository->find($id, 'transformToDetailDTO');
    }



    public function updateClass(int $id, DailyClassDetailDTO $data)
    {
        $data->id = $id;
        $this->dailyClassRepository->update($data);

        return Inertia::render('LearningProject/ListLearningProjects');
    }
}
