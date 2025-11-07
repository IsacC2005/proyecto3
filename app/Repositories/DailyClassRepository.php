<?php

namespace App\Repositories;

use App\Constants\TDTO;
use App\DTOs\Details\DailyClassDetailDTO;
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
use App\DTOs\Details\DTODetail;
use App\DTOs\Details\ItemEvaluationDetailDTO;
use App\Models\EvaluationItem;
use DateTime;
use Illuminate\Support\Facades\DB;

class DailyClassRepository extends TransformDTOs implements DailyClassInterface
{

    public function create(DailyClassDTO | DailyClassDetailDTO $dailyClass): DailyClassDTO | null
    {
        try {
            $dailyClassModel = null;
            DB::transaction(function () use ($dailyClass, $dailyClassModel) {
                if ($dailyClass instanceof DailyClassDTO) {
                    $dailyClassModel = DailyClass::create([
                        'date' => $dailyClass->date->format('Y-m-d'),
                        'title' => $dailyClass->title,
                        'content' => $dailyClass->content,
                        'learning_project_id' => $dailyClass->learningProjectId
                    ]);

                    if (!$dailyClassModel) {
                        throw new DailyClassNotCreateException();
                    }

                    foreach ($dailyClass->getItemEvaluations() as $evaluation) {
                        $dailyClassModel->evaluation_items()->create([
                            'title' => $evaluation->title
                        ]);
                    }
                } else {
                    $dailyClassModel = DailyClass::create([
                        'date' => $dailyClass->date->format('Y-m-d'),
                        'title' => $dailyClass->title,
                        'content' => $dailyClass->content,
                        'learning_project_id' => $dailyClass->learningProject->id
                    ]);


                    if (!$dailyClassModel) {
                        throw new DailyClassNotCreateException();
                    }

                    foreach ($dailyClass->getItemEvaluations() as $indicator) {
                        $dailyClassModel->evaluation_items()->create([
                            'title' => $indicator->title
                        ]);
                    }

                    $dailyClassModel->save();
                }
            });

            return $dailyClassModel ? $this->transformToDTO($dailyClassModel) : null;
        } catch (\Throwable $th) {
            throw $th;
        }
    }



    public function find(int $id, ?string $fn = TDTO::SUMMARY): DailyClassDTO | DailyClassDetailDTO
    {
        try {
            $dailyClassModel = DailyClass::find($id);

            if (!$dailyClassModel) {
                throw new DailyClassNotFindException();
            }

            return $this->$fn($dailyClassModel);
        } catch (\Throwable $th) {
            throw new DailyClassNotFindException($th->getMessage());
        }
    }



    public function findAll(?string $fn = TDTO::SUMMARY): array
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



    public function findByLearningProject(int $projectId, ?string $fn = null): array
    {
        try {
            $dailyClassModel = DailyClass::where('learning_project_id', $projectId)->get();
            if (!$dailyClassModel) {
                throw new DailyClassNotFindException();
            }

            return $this->transformListDTO($dailyClassModel, $fn);
        } catch (\Throwable $th) {
            throw new DailyClassNotFindException();
        }
    }



    public function search(DailyClassDTO $dailyClass): array
    {
        return [];
    }





    public function update(DailyClassDetailDTO $dailyClass): DailyClassDetailDTO
    {
        try {
            $dailyClassModel = DailyClass::find($dailyClass->id);

            if (!$dailyClassModel) {
                throw new DailyClassNotExistException();
            }

            $dailyClassModel->date = $dailyClass->date->format('Y-m-d');
            $dailyClassModel->title = $dailyClass->title;
            $dailyClassModel->content = $dailyClass->content;


            $dailyClassModel->save();

            EvaluationItem::where('daily_class_id', $dailyClassModel->id)->delete();
            foreach ($dailyClass->getItemEvaluations() as $item) {

                if ($item->title !== '') {
                    EvaluationItem::create([
                        'title' => $item->title,
                        'daily_class_id' => $dailyClassModel->id
                    ]);
                }
            }


            return $this->transformToDetailDTO($dailyClassModel);
        } catch (\Throwable $th) {
            throw new DailyClassNotUpdateException($th->getMessage());
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
            learningProjectId: $model->learning_project->id
        );
    }

    protected function transformToDetailDTO(Model $model): DTODetail
    {
        $class = new DailyClassDetailDTO(
            id: $model->id,
            date: new \DateTime($model->date),
            title: $model->title,
            content: $model->content,
            learningProject: null,
        );

        foreach ($model->evaluation_items as $item) {
            $class->addItemEvaluation(new ItemEvaluationDetailDTO(
                id: $item->id,
                title: $item->title
            ));
        }
        return $class;
    }
}
