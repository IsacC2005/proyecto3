<?php

namespace App\Services;

use App\DTOs\Details\DailyClassDetailDTO;
use App\DTOs\Summary\DailyClassDTO;
use App\Exceptions\DailyClass\DailyClassNotCreateException;
use App\Repositories\Interfaces\DailyClassInterface;
use DateTime;

class DailyClassServices
{



    public function __construct(
        private DailyClassInterface $dailyClassRepository
    ) {}



    public function createDailyClass(DailyClassDTO $data)
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
    }
}
