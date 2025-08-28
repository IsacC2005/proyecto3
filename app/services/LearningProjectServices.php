<?php

namespace App\Services;

use App\Constants\TDTO;
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
        return $this->projectRepository->find($id, TDTO::DETAIL);
    }

    public function findByTeacher(): array
    {
        $user = Auth::user();
        if ($user->userable_type === 'App\Models\Teacher') {
            $teacher = $user->userable;
        } else {
            return [];
        }

        return $this->projectRepository->findByTeacher($teacher->id ? $teacher->id : 0, TDTO::DETAIL);
    }


    public function findByEnrollment(int $enrollmentId, int $teacherId)
    {

        $assingEnrollmentTeacher = $this->enrollmentRepository->teacherItsAssing($enrollmentId, $teacherId);

        if (!$assingEnrollmentTeacher) {
            throw new LearningProjectNotFindException("Este Profesor no tiene asignado esta matricula", 422);
        }

        $rs = $this->projectRepository->findByEnrollment($enrollmentId);

        if ($rs) {
            return Inertia::render('LearningProject/CreateLearningProject', [
                'learningProject' => $rs,
                'teacherId' => $teacherId

            ]);
        } else {
            return Inertia::render('LearningProject/CreateLearningProject', [
                'learningProject' => [],
                'enrollmentId' => $enrollmentId,
                'teacherId' => $teacherId

            ]);
        }
    }

    public function getAllProjects() {}

    public function findProjectById(int $id) {}

    public function updateProject(int $id, array $data) {}

    public function deleteProject(int $id) {}
}
