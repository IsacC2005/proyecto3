<?php

namespace App\Repositories;

use App\DTOs\EnrollmentDTO;
use App\Models\LearningProject;
use App\DTOs\LearningProjectDTO;
use App\DTOs\TeacherDTO;
use App\Exceptions\LearningProject\LearningProjectNotCreatedException;
use App\Exceptions\LearningProject\LearningProjectNotDeleteException;
use App\Exceptions\LearningProject\LearningProjectNotExistException;
use App\Exceptions\LearningProject\LearningProjectNotFindException;
use App\Exceptions\LearningProject\LearningProjectNotUpdateException;
use App\Exceptions\Teacher\TeacherNotExistException;
use App\Models\Enrollment;
use App\Models\Teacher;
use App\Repositories\Interfaces\LearningProjectInterface;
use App\Repositories\Traits\LearningProjectTrait;

class LearningProjectRepository implements LearningProjectInterface
{

    use LearningProjectTrait;

    public function create(LearningProjectDTO $learningProject): LearningProjectDTO
    {
        try {
            $teacher = Teacher::find($learningProject->teacher_id);
            $enrollment = Enrollment::find($learningProject->enrollment_id);

            if (!$enrollment || !$teacher) {
                throw new LearningProjectNotCreatedException();
            }

            $projectModel = LearningProject::create([
                'title' => $learningProject->title,
                'content' => $learningProject->content,
            ])->teacher()->associate($teacher)
                ->enrollment()->associate($enrollment);

            if (!$projectModel) {
                throw new LearningProjectNotCreatedException();
            }

            return $this->transformToDTO($projectModel);
        } catch (\Throwable $th) {
            throw new LearningProjectNotCreatedException();
        }
    }



    public function find($id): LearningProjectDTO
    {
        try {
            $project = LearningProject::find($id);
            if (!$project) {
                throw new LearningProjectNotFindException();
            }

            return $this->transformToDTO($project);
        } catch (\Throwable $th) {
            throw new LearningProjectNotFindException();
        }
    }



    public function findAll(): array
    {
        try {
            $projects = LearningProject::all();
            if(!$projects){
                throw new LearningProjectNotFindException();
            }
            return $this->transformListDTO($projects->toArray());
        } catch (\Throwable $th) {
            throw new LearningProjectNotFindException();
        }
    }



    public function findByTeacher(int $teacher_id): array
    {
        try {
            
        $teacherModel = Teacher::find($teacher_id);
        if (!$teacherModel) {
            throw new TeacherNotExistException();
        }

        $projects = LearningProject::where('teacher_id', $teacherModel->id)->get();
        return $this->transformListDTO($projects->toArray());
        } catch (\Throwable $th) {
            throw new LearningProjectNotFindException();
        }
    }



    public function search(LearningProjectDTO $learningProject): array
    {
        return ['agrega','algo'];
    }



    public function update(LearningProjectDTO $learningProject): LearningProjectDTO
    {
        try {
            $projectModel = LearningProject::find($learningProject->id);
            if (!$projectModel) {
                throw new LearningProjectNotFindException();
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
        } catch (\Throwable $th) {
            throw new LearningProjectNotUpdateException();
        }
    }




    public function delete($id): void
    {
        try {
            $project = LearningProject::find($id);
            if (!$project) {
                throw new LearningProjectNotExistException();
            }
            $project->delete();
        } catch (\Throwable $th) {
            throw new LearningProjectNotDeleteException();
        }
    }
}
