<?php

namespace App\Repositories;

use App\Constants\TDTO;
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
use App\DTOs\Details\NotesDetailDTO;
use App\DTOs\Searches\DTOSearch;
use App\DTOs\Summary\EnrollmentDTO;
use App\Factories\DailyClassFactory;
use App\Factories\EnrollmentFactory;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class LearningProjectRepository extends TransformDTOs implements LearningProjectInterface
{

    public function create(LearningProjectDetailDTO $learningProject): LearningProjectDTO
    {
        try {
            $projectModel = LearningProject::create([
                'title' => $learningProject->title,
                'content' => $learningProject->content,
                'school_moment' => $learningProject->schoolMoment,
                'teacher_id' => $learningProject->teacher->id,
                'enrollment_id' => $learningProject->enrollment->id,
            ]);

            if (!$projectModel) {
                throw new LearningProjectNotCreatedException();
            }

            return $this->transformToDTO($projectModel);
        } catch (\Throwable $th) {
            throw new LearningProjectNotCreatedException($th->getMessage());
        }
    }



    public function existProjectForTeacher(int $project_id, int $teacher_id): bool
    {
        $rs = $this->existProject($project_id);

        if (!$rs) {
            throw new LearningProjectNotExistException();
        }

        return LearningProject::where('id', $project_id)->where('teacher_id', $teacher_id)->exists();
    }



    public function existProject(int $id): bool
    {
        return LearningProject::where('id', $id)->exists();
    }


    public function existProjectByTeacheByYearByMoment(int $teacherId, int $enrollmentId, int $schoolMoment): bool
    {
        return (bool) LearningProject::where('teacher_id', $teacherId)
            ->where('enrollment_id', $enrollmentId)
            ->where('school_moment', $schoolMoment)
            ->exists();
    }



    public function find(int $id, ?string $fn = TDTO::SUMMARY): LearningProjectDTO | LearningProjectDetailDTO
    {
        try {
            $project = LearningProject::find($id);
            if (!$project) {
                throw new LearningProjectNotFindException();
            }

            return $this->$fn($project);
        } catch (\Throwable $th) {
            throw new LearningProjectNotFindException($th->getMessage());
        }
    }



    public function findAll(?string $fn = null): array
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




    public function findByEnrollment(int $enrollmentId): array
    {
        try {
            $project = LearningProject::where('enrollment_id', $enrollmentId)->get();

            if (!$project) {
                return [];
            }

            return $this->transformListDTO($project);
        } catch (\Throwable $th) {
            throw new LearningProjectNotFindException($th->getMessage());
        }
    }



    public function findByEnrollmentAndMoment(int $enrollmentId, int $moment): LearningProjectDTO | null
    {
        try {
            $project = LearningProject::where('enrollment_id', $enrollmentId)
                ->where('school_moment', $moment)->first();

            if (!$project) {
                //throw new \Exception($enrollmentId . ' ' . $moment);
                return null;
            }

            return $this->transformToDTO($project);
        } catch (\Throwable $th) {
            throw new LearningProjectNotFindException($th->getMessage());
        }
    }



    public function findByTeacher(int $teacherId, ?string $fn = null): array
    {
        try {

            $projects = LearningProject::where('teacher_id', $teacherId)->get();

            return $this->transformListDTO($projects, $fn);
        } catch (\Throwable $th) {
            throw new LearningProjectNotFindException($th->getMessage());
        }
    }



    public function findOnDate(string $schoolYear, string $schoolMoment, ?int $teacherId = null, ?string $fn = TDTO::SUMMARY): LearningProjectDTO | LearningProjectDetailDTO | null
    {
        try {
            //return null;

            if ($teacherId) {
                $project = LearningProject::whereHas('enrollment', function ($query) use ($schoolYear, $schoolMoment, $teacherId) {
                    $query->where('school_year', $schoolYear)->where('school_moment', $schoolMoment)->where('teacher_id', $teacherId);
                })->first();
            } else {
                $project = LearningProject::whereHas('enrollment', function ($query) use ($schoolYear, $schoolMoment) {
                    $query->where('school_year', $schoolYear)->where('school_moment', $schoolMoment);
                })->first();
            }
            if (!$project) {
                return null;
            }
            return $this->$fn($project);
        } catch (\Throwable $th) {
            throw $th;
        }
    }



    public function countStudents(int $projectId): int
    {
        $project = LearningProject::with(['enrollment.students'])->find($projectId);
        return $project->enrollment->students->length;
    }




    public function getAllEvaluationByProject(int $projectId): array
    {
        $project = LearningProject::with(
            [
                'daily_classes.evaluation_items.students' => function ($query) {
                    $query->withPivot('note');
                }
            ]
        )->find($projectId);

        if (!$project) {
            return [];
        }

        $classes = [];
        $students = [];

        foreach ($project->daily_classes as $dailyClass) {
            $indicators = $dailyClass->evaluation_items->map(function ($evaluationItem) {
                return [
                    'id' => $evaluationItem->id,
                    'name' => $evaluationItem->title
                ];
            })->toArray();

            $classes[] = [
                'id' => $dailyClass->id,
                'title' => $dailyClass->title,
                'indicators' => $indicators
            ];
        }
        $data = [
            'projectId' => $project->id,
            'classes' => $classes,
            'students' => array_values($students)
        ];

        return $data;
    }




    public function getAllNoteStudent(int $projectId, int $studentId): array
    {
        $project = LearningProject::find($projectId);

        $classes = $project->daily_classes;

        $AllNote = [];

        foreach ($classes as $class) {
            $evaluation_items = $class->evaluation_items()
                ->whereHas('students', function ($query) use ($studentId) {
                    $query->where('students.id', $studentId);
                })
                ->with(['students' => function ($query) use ($studentId) {
                    $query->where('students.id', $studentId)->withPivot('note');
                }])
                ->get();

            $notes = [];
            foreach ($evaluation_items as $item) {
                $student = $item->students->first();
                if ($student) {
                    $notes[$item->title] = $student->pivot->note;
                }
            }

            $AllNote[] = [
                'classTitle' => $class->title,
                'notes' => $notes
            ];
        }
        return $AllNote;
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

            if ($learningProject->teacherId & $learningProject->enrollmentId != 0) {
                $teacher = Teacher::find($learningProject->teacherId);
                if ($teacher) {
                    $projectModel->teacher()->associate($teacher);
                }
            }

            if ($learningProject->enrollmentId & $learningProject->enrollmentId !== 0) {
                $enrollment = Enrollment::find($learningProject->enrollmentId);
                if ($enrollment) {
                    $projectModel->enrollment()->associate($enrollment);
                }
            }

            $projectModel->save();

            return $this->transformToDTO($projectModel);
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

    protected function transformToDTO(Model $model): LearningProjectDTO
    {
        //$teacher = $model->teacher;
        //$enrollment = $model->enrollment;
        //       $teacherDTO = TeacherTrait::transformToDTO($teacher) ?? null;

        return new LearningProjectDTO(
            id: $model->id,
            title: $model->title,
            content: $model->content,
            schoolMoment: $model->school_moment,
            teacherId: $model->teacher_id,
            enrollmentId: $model->enrollment_id
        );
    }

    protected function transformToDetailDTO(Model $model): DTODetail
    {

        $project = new LearningProjectDetailDTO(
            id: $model->id,
            title: $model->title,
            content: $model->content,
            schoolMoment: $model->school_moment,
            teacher: null,
            enrollment: null,
        );



        $classes = $model->daily_classes;

        foreach ($classes as $class) {
            $project->addDailyClasses(DailyClassFactory::fromArray([
                'id' => $class->id,
                'date' => $class->date,
                'title' => $class->title,
                'content' => $class->content
            ]));
        }

        return $project;
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
