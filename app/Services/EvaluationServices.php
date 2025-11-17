<?php

namespace App\Services;

use App\Constants\TDTO;
use App\DTOs\Details\DailyClassDetailDTO;
use App\Repositories\Interfaces\DailyClassInterface;
use App\Repositories\Interfaces\ItemEvaluationInterface;
use App\Repositories\Interfaces\LearningProjectInterface;
use App\Repositories\Interfaces\StudentInterface;
use Inertia\Inertia;

class EvaluationServices
{
    public function __construct(
        private StudentInterface $studentRepository,
        private DailyClassInterface $dailyClassRepository,
        private ItemEvaluationInterface $itemEvaluationRepository,
        private LearningProjectInterface $projectRepository
    ) {}


    public function listStudentsByClass(int $classId)
    {
        $students = $this->studentRepository->findStudentByDailyClass($classId);

        $class = $this->dailyClassRepository->find($classId, TDTO::DETAIL);

        $allNote = $this->itemEvaluationRepository->getAllEvaluationByClass($classId);

        //$project = $this->

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


    public function evaluateRandomToProject(int $projectId)
    {
        $project = $this->projectRepository->find($projectId);

        if (!$project) {
            // Or throw an exception
            return;
        }

        $students = $this->studentRepository->findStudentByEnrollment($project->enrollmentId);
        $dailyClasses = $this->dailyClassRepository->findByLearningProject($projectId, TDTO::DETAIL);

        $notes = ['PL', 'L', 'EP', 'PM', 'SL'];

        foreach ($students as $student) {
            /** @var DailyClassDetailDTO $class */
            foreach ($dailyClasses as $class) {
                foreach ($class->getItemEvaluations() as $item) {
                    $this->evaluateStudent($item->id, $student->id, $notes[array_rand($notes)]);
                }
            }
        }
    }
}
