<?php

namespace App\Repositories;

use App\DTOs\EnrollmentDTO;
use App\Models\LearningProject;
use App\DTOs\LearningProjectDTO;
use App\DTOs\TeacherDTO;
use App\Models\Enrollment;
use App\Models\Teacher;
use App\Repositories\Interfaces\LearningProjectInterface;
use App\Repositories\Traits\LearningProjectTrait;

class LearningProjectRepository implements LearningProjectInterface
{

    use LearningProjectTrait;

    public function create(LearningProjectDTO $learningProject): bool
    {

        if (
            empty($learningProject->title) ||
            empty($learningProject->content) ||
            $learningProject->teacher_id < 1 ||
            $learningProject->enrollment_id < 1
        ) {
            return false;
        }

        $teacher = Teacher::find($learningProject->teacher_id);
        $enrollment = Enrollment::find($learningProject->enrollment_id);

        if (!$enrollment || !$teacher) {
            return false;
        }

        $projectModel = LearningProject::create([
            'title' => $learningProject->title,
            'content' => $learningProject->content,
        ])->teacher()->associate($teacher)
            ->enrollment()->associate($enrollment);

        if (!$projectModel) {
            return false;
        }

        return true;
    }



    public function find($id): LearningProjectDTO | null
    {
        $project = LearningProject::find($id);
        if (!$project) {
            return null;
        }

        return $this->transformToDTO($project);
    }



    public function findAll(): array
    {
        $projects = LearningProject::all();
        return $this->transformListDTO($projects->toArray());
    }



    public function findByTeacher(int $teacher_id): array {
        $teacherModel = Teacher::find($teacher_id);
        if (!$teacherModel) {
            return [];
        }

        $projects = LearningProject::where('teacher_id', $teacherModel->id)->get();
        return $this->transformListDTO($projects->toArray());
    }



    public function search(LearningProjectDTO $learningProject): array
    {
        return [];
    }



    public function update(LearningProjectDTO $learningProject): bool
    {
        $projectModel = LearningProject::find($learningProject->id);
        if (!$projectModel) {
            return false;
        }

        $projectModel->title = $learningProject->title;
        $projectModel->content = $learningProject->content;

        if ($learningProject->teacher_id) {
            $teacher = Teacher::find($learningProject->teacher_id);
            if ($teacher) {
                $projectModel->teacher()->associate($teacher);
            }
        }

        if ($learningProject->enrollment_id) {
            $enrollment = Enrollment::find($learningProject->enrollment_id);
            if ($enrollment) {
                $projectModel->enrollment()->associate($enrollment);
            }
        }

        return $projectModel->save();
    }




    public function delete($id): bool
    {
        $project = LearningProject::find($id);
        if (!$project) {
            return false;
        }
        return $project->delete();
    }
}
