<?php

namespace App\Services;

use App\Constants\TDTO;
use App\DTOs\Details\DailyClassDetailDTO;
use App\DTOs\Summary\DailyClassDTO;
use App\Exceptions\DailyClass\DailyClassNotCreateException;
use App\Exceptions\LearningProject\LearningProjectNotFindException;
use App\Repositories\Interfaces\DailyClassInterface;
use App\Repositories\Interfaces\LearningProjectInterface;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DailyClassServices
{



    public function __construct(
        private DailyClassInterface $dailyClassRepository,
        private LearningProjectInterface $projectRepository,
        private DatesActual $datesActual
    ) {}



    public function createDailyClassShowPage()
    {
        $teacher_id = Auth::user()->userable->id;



        if (!$teacher_id) {
            $teacher_id = -1;
        }

        $year = $this->datesActual->getSchoolYearActual();
        $moment = $this->datesActual->getSchoolMomentActual();

        $project = $this->projectRepository->findOnDate($year, $moment, $teacher_id);

        if (!$project) {
            return Inertia::render('Dashboard');
        }

        return Inertia::render(
            'DailyClass/CreateReferent',
            [
                'projectId' => $project->id
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
