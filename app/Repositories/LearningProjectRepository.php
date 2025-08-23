<?php

namespace App\Repositories;


use App\DTOs\Summary\LearningProjectDTO;
use App\Models\LearningProject;
use App\Exceptions\LearningProject\LearningProjectNotCreatedException;
use App\Exceptions\LearningProject\LearningProjectNotDeleteException;
use App\Exceptions\LearningProject\LearningProjectNotExistException;
use App\Exceptions\LearningProject\LearningProjectNotFindException;
use App\Exceptions\LearningProject\LearningProjectNotUpdateException;
use App\Exceptions\Teacher\TeacherNotExistException;
use App\Models\Enrollment;
use App\Models\Teacher;
use App\Repositories\Interfaces\LearningProjectInterface;
use App\Repositories\TransformDTOs\TransformDTOs;
use App\DTOs\Summary\DTOSummary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\DTOs\Details\DTODetail;
use App\DTOs\Details\LearningProjectDetailDTO;
use App\DTOs\Searches\DTOSearch;

class LearningProjectRepository extends TransformDTOs implements LearningProjectInterface
{

    public function create(LearningProjectDetailDTO $learningProject): LearningProjectDTO
    {
        try {
            $teacher = Teacher::find($learningProject->teacher->id);
            $enrollment = Enrollment::find($learningProject->enrollment->id);

            if (!$enrollment || !$teacher) {
                throw new LearningProjectNotCreatedException('Teacher or Enrollment not found');
            }

            $projectModel = LearningProject::create([
                'title' => $learningProject->title,
                'content' => $learningProject->content,
                'teacher_id' => $teacher->id,
                'enrollment_id' => $enrollment->id,
            ]);



            if (!$projectModel) {
                throw new LearningProjectNotCreatedException();
            }

            return $this->transformToDTO($projectModel);
        } catch (\Throwable $th) {
            throw new LearningProjectNotCreatedException($th->getMessage());
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
            if (!$projects) {
                throw new LearningProjectNotFindException();
            }
            return $this->transformListDTO($projects);
        } catch (\Throwable $th) {
            throw new LearningProjectNotFindException();
        }
    }




    public function findByEnrollment(int $enrollment_id): LearningProjectDTO | null
    {
        try {
            $project = LearningProject::where('enrollment_id', $enrollment_id)->first();
            if (!$project) {
                return null;
                throw new LearningProjectNotFindException();
            }

            return $this->transformToDTO($project);
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
            return $this->transformListDTO($projects);
        } catch (\Throwable $th) {
            throw new LearningProjectNotFindException();
        }
    }



    public function search(LearningProjectDTO $learningProject): array
    {
        return ['agrega', 'algo'];
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
            throw new LearningProjectNotDeleteException($th->getMessage());
        }
    }

    protected function transformToDTO(Model $model): DTOSummary
    {
        $teacher = $model->teacher;
        $enrollment = $model->enrollment;
        //       $teacherDTO = TeacherTrait::transformToDTO($teacher) ?? null;

        return new LearningProjectDTO(
            id: $model->id,
            title: $model->title,
            content: $model->content,
            teacher_id: $teacher->id,
            enrollment_id: $enrollment->id
        );
    }

    protected function transformToDetailDTO(Model $model): DTODetail
    {

        return new LearningProjectDetailDTO(
            id: $model->id,
            title: $model->title,
            content: $model->content,
            teacher: null,
            enrollment: null,
        );
    }

    protected function transformToSearchDTO(Model $model): DTOSearch
    {
        return new DTOSearch(
            id: $model->id,
            title: $model->title,
            teacher_id: $model->teacher_id,
            enrollment_id: $model->enrollment_id
        );
    }
}
