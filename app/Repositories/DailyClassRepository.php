<?php

namespace App\Repositories;

use App\Repositories\Interfaces\DailyClassInterface;
use App\DTOs\Summary\DailyClassDTO;
use App\Exceptions\DailyClass\DailyClassNotCreateException;
use App\Exceptions\DailyClass\DailyClassNotDeleteException;
use App\Exceptions\DailyClass\DailyClassNotExistException;
use App\Exceptions\DailyClass\DailyClassNotFindException;
use App\Exceptions\DailyClass\DailyClassNotUpdateException;
use App\Models\DailyClass;
use App\Repositories\TransformDTOs\TransformDTOs;
use App\DTOs\Summary\DTOSummary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\DTOs\Details\DTODetail;
use App\DTOs\Searches\DTOSearch;

class DailyClassRepository extends TransformDTOs implements DailyClassInterface
{

    public function create(DailyClassDTO $dailyClass): DailyClassDTO
    {
        try {
            $dailyClassModel = DailyClass::create([
                'date' => $dailyClass->date,
                'title' => $dailyClass->title,
                'content' => $$dailyClass->content
            ]);

            if (!$dailyClassModel) {
                throw new DailyClassNotCreateException();
            }

            return $this->transformToDTO($dailyClassModel);
        } catch (\Throwable $th) {
            throw new DailyClassNotCreateException();
        }
    }



    public function find($id): DailyClassDTO
    {
        try {
            $dailyClassModel = DailyClass::find($id);

            if (!$dailyClassModel) {
                throw new DailyClassNotFindException();
            }
            return $this->transformToDTO($dailyClassModel);
        } catch (\Throwable $th) {
            throw new DailyClassNotFindException();
        }
    }



    public function findAll(): array
    {
        try {
            $dailyClassModel = DailyClass::all();
            if (!$dailyClassModel) {
                throw new DailyClassNotFindException();
            }
            return $this->transformListDTO($dailyClassModel);
        } catch (\Throwable $th) {
            throw new DailyClassNotFindException();
        }
    }



    public function findByLearningProject(int $project_id): array
    {
        try {
            $dailyClassModel = DailyClass::where('learning_project_id', $project_id)->get();
            if (!$dailyClassModel) {
                throw new DailyClassNotFindException();
            }

            return $this->transformListDTO($dailyClassModel);
        } catch (\Throwable $th) {
            throw new DailyClassNotFindException();
        }
    }



    public function search(DailyClassDTO $dailyClass): array
    {
        return [];
    }



    public function update(DailyClassDTO $dailyClass): DailyClassDTO
    {
        try {
            $dailyClassModel = DailyClass::find($dailyClass->id);

            if (!$dailyClassModel) {
                throw new DailyClassNotExistException();
            }

            $dailyClassModel->date = $dailyClass->date;
            $dailyClassModel->title = $dailyClass->title;
            $dailyClassModel->content = $dailyClass->content;

            $dailyClassModel->save();

            return $this->transformToDTO($dailyClassModel);
        } catch (\Throwable $th) {
            throw new DailyClassNotUpdateException();
        }
    }



    public function delete($id): void
    {
        try {
            $dailyClassModel = DailyClass::find($id);

            if (!$dailyClassModel) {
                throw new DailyClassNotExistException();
            }

            $dailyClassModel->delete();
        } catch (\Throwable $th) {
            throw new DailyClassNotDeleteException();
        }
    }

	protected function transformToDTO(Model $model): DTOSummary
    {
        return new DailyClassDTO(
            id: $model->id,
            date: new \DateTime($model->date),
            title: $model->title,
            content: $model->content,
            learning_project_id: $model->learning_project->id
        );
    }

	protected function transformToDetailDTO(Model $model): DTODetail
    {
        // TODO
    }

	protected function transformToSearchDTO(Model $model): DTOSearch
    {
        // TODO
    }
}
