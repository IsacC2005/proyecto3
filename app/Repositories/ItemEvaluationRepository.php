<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ItemEvaluationInterface;
use App\DTOs\Summary\ItemEvaluationDTO;
use App\Models\EvaluationItem;
use App\Repositories\TransformDTOs\TransformDTOs;
use Illuminate\Database\Eloquent\Model;
use App\DTOs\Summary\DTOSummary;
use App\DTOs\Details\DTODetail;
use App\DTOs\Summary\EvaluationItemsStudentDTO;
use App\Exceptions\EvaluationItem\EvaluationNotExistException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ItemEvaluationRepository extends TransformDTOs implements ItemEvaluationInterface
{

    public function create(ItemEvaluationDTO $itemEvaluation): ItemEvaluationDTO
    {
        // TODO
    }

    public function find(int $id): ItemEvaluationDTO
    {
        // TODO
    }

    public function findAll(?string $fn = null): array
    {
        // TODO
    }

    public function getAllEvaluationByClass(int $classId): array
    {

        $evaluationItemIds = EvaluationItem::where('daily_class_id', $classId)
            ->pluck('id');

        // Si no hay ítems, devolver array vacío inmediatamente.
        if ($evaluationItemIds->isEmpty()) {
            return [];
        }

        $rawNotes = DB::table('evaluation_item_student')
            ->select('evaluation_item_id', 'student_id', 'note')
            ->whereIn('evaluation_item_id', $evaluationItemIds)
            ->get();

        $result = $rawNotes->map(function ($note) {
            return new EvaluationItemsStudentDTO(
                itemEvaluationId: $note->evaluation_item_id,
                studentId: $note->student_id,
                note: $note->note
            );
        })->toArray();

        return $result;
    }

    public function evaluateClass(int $evaluationId, int $studentId, string $note): void
    {
        DB::transaction(function () use ($evaluationId, $studentId, $note) {
            $evaluation = EvaluationItem::find($evaluationId);


            if (!$evaluation) {
                throw new EvaluationNotExistException('este Evaluacion no existe');
            }

            $evaluation->students()->syncWithoutDetaching([$studentId => ['note' => $note]]);
        });
    }


    public function update(ItemEvaluationDTO $itemEvaluation): ItemEvaluationDTO
    {
        // TODO
    }

    public function delete(int $id): void
    {
        // TODO
    }

    public function deleteAllByDailyClass(int $daily_class_id): void
    {
        // TODO
    }

    protected function transformToDTO(Model $model): DTOSummary
    {
        //throw new \Exception($model->students()->id);
        return new EvaluationItemsStudentDTO(
            itemEvaluationId: $model->id,
            studentId: $model->students->id,
            note: $model->pivot->note
        );
    }

    protected function transformToDetailDTO(Model $model): DTODetail
    {
        // TODO
    }
}
