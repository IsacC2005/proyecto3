<?php

namespace App\Services;

use App\Constants\TDTO;
use App\Repositories\Interfaces\DailyClassInterface;
use App\Repositories\Interfaces\ItemEvaluationInterface;
use App\Repositories\Interfaces\StudentInterface;
use Inertia\Inertia;

class EvaluationServices
{
    public function __construct(
        private StudentInterface $studentRepository,
        private DailyClassInterface $dailyClassRepository,
        private ItemEvaluationInterface $itemEvaluationRepository
    ) {}


    public function listStudentsByClass(int $classId)
    {
        $students = $this->studentRepository->findStudentByDailyClass($classId);

        $class = $this->dailyClassRepository->find($classId, TDTO::DETAIL);

        $allNote = $this->itemEvaluationRepository->getAllEvaluationByClass($classId);

        return Inertia::render('Evaluation/Evaluate', [
            'students' => $students,
            'dailyClass' => $class->toArray(),
            'allNote' => $allNote
        ]);
    }

    public function evaluateStudent(int $evaluationId, int $studentId, string $note)
    {
        $this->itemEvaluationRepository->evaluateClass($evaluationId, $studentId, $note);
    }
}
