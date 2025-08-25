<?php

namespace App\Services;

use App\Repositories\Interfaces\StudentInterface;

class EvaluationServices
{
    public function __construct(
        private StudentInterface $studentRepository
    ) {}


    public function listStudentsByClass(int $class_id)
    {
        return $this->studentRepository->findStudentByDailyClass($class_id);
    }
}
