<?php

namespace App\Services;

use App\DTOs\Details\LearningProjectDetailDTO;
use App\Exceptions\LearningProject\LearningProjectNotCreatedException;
use App\Repositories\Interfaces\LearningProjectInterface;
use Inertia\Inertia;

class LearningProjectServices
{
    public function __construct(
        private LearningProjectInterface $projectRepository,
        private DailyClassServices $dailyClassServices
    ) {}



    public function createProject(LearningProjectDetailDTO $data)
    {
        try {
            $project = $this->projectRepository->create($data);

            foreach ($data->getDailyClasses() as $class) {
                $class->learning_project_id = $project->id;
                $this->dailyClassServices->createDailyClass($class);
            }
        } catch (\Throwable $th) {
            $this->projectRepository->delete($project->id);
            throw new LearningProjectNotCreatedException($th->getMessage());
        }
    }



    public function findByEnrollment(int $enrollment_id, int $teacher_id)
    {

        $rs = $this->projectRepository->findByEnrollment($enrollment_id);

        if ($rs) {
            return Inertia::render('LearningProject/CreateLearningProject', [
                'enrollment' => $rs,
                'teacher_id' => $teacher_id

            ]);
        } else {
            return Inertia::render('LearningProject/CreateLearningProject', [
                'enrollment' => [],
                'enrollment_id' => $enrollment_id,
                'teacher_id' => $teacher_id

            ]);
        }
    }

    public function getAllProjects() {}

    public function findProjectById(int $id) {}

    public function updateProject(int $id, array $data) {}

    public function deleteProject(int $id) {}
}
