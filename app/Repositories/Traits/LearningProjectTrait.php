<?php

namespace App\Repositories\Traits;

use App\DTOs\LearningProjectDTO;
use App\Models\LearningProject;
use App\Models\Teacher;

trait LearningProjectTrait
{

    use TeacherTrait;

    private function transformListDTO(array $projects): array
    {
        return array_map([$this, 'transformToDTO'], $projects);
    }

    private function transformToDTO(LearningProject $project): LearningProjectDTO
    {
        $teacher = $project->teacher;
        $enrollment = $project->enrollment;
 //       $teacherDTO = TeacherTrait::transformToDTO($teacher) ?? null;

        return new LearningProjectDTO(
            id: $project->id,
            title: $project->title,
            content: $project->content,
            teacher_id: $teacher->id,
            enrollment_id: $enrollment->id
        );
    }
}

?>