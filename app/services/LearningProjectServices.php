<?php

namespace App\Services;

use App\DTOs\Details\LearningProjectDetailDTO;
use App\Exceptions\LearningProject\LearningProjectNotCreatedException;
use App\Exceptions\LearningProject\LearningProjectNotFindException;
use App\Repositories\Interfaces\EnrollmentInterface;
use App\Repositories\Interfaces\LearningProjectInterface;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LearningProjectServices
{
    public function __construct(
        private LearningProjectInterface $projectRepository,
        private EnrollmentInterface $enrollmentRepository,
        private DailyClassServices $dailyClassServices,
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


    public function findById(int $id)
    {
        return $this->projectRepository->find($id, 'transformToDetailDTO');
    }

    public function findByTeacher(): array
    {
        $teacher = Auth::user()->userable;

        return $this->projectRepository->findByTeacher($teacher->id ? $teacher->id : 0, 'transformToDetailDTO');
    }


    public function findByEnrollment(int $enrollment_id, int $teacher_id)
    {

        $assingEnrollmentTeacher = $this->enrollmentRepository->teacherItsAssing($enrollment_id, $teacher_id);

        if (!$assingEnrollmentTeacher) {
            throw new LearningProjectNotFindException("Este Profesor no tiene asignado esta matricula", 422);
        }

        $rs = $this->projectRepository->findByEnrollment($enrollment_id);

        if ($rs) {
            return Inertia::render('LearningProject/CreateLearningProject', [
                'learning_project' => $rs,
                'teacher_id' => $teacher_id

            ]);
        } else {
            return Inertia::render('LearningProject/CreateLearningProject', [
                'learning_project' => [],
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
