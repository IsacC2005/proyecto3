<?php

namespace App\Repositories;

use App\Repositories\Interfaces\TrainingAreaInterface;
use App\DTOs\Summary\TrainingAreaDTO;
use App\Repositories\TransformDTOs\TransformDTOs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\DTOs\Summary\DTOSummary;
use App\DTOs\Details\DTODetail;
use App\Models\TrainingArea;

class TrainingAreaRepository extends TransformDTOs implements TrainingAreaInterface
{
    public function create(TrainingAreaDTO $trainingArea): TrainingAreaDTO | null
    {
        // TODO
    }

    public function find(int $id): TrainingAreaDTO | null
    {
        // TODO
    }

    public function findAll(): array
    {
        $data = TrainingArea::all();
        return $this->transformListDTO($data);
    }

    public function delete(int $id): void
    {
        // TODO
    }

    /**
     * @param TrainingArea $model
     * @return TrainingAreaDTO
     */

    protected function transformToDTO(Model $model): DTOSummary
    {
        return new TrainingAreaDTO(
            id: $model->id,
            title: $model->title
        );
    }

    protected function transformToDetailDTO(Model $model): DTODetail
    {
        // TODO
    }
}
