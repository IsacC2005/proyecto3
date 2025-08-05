<?php


namespace App\Repositories\Traits;

use App\DTOs\TeacherDTO;
use App\Models\Teacher;

trait TeacherTrait
{
    private function transformListDTO(array $teachers): array
    {
        return array_map([$this, 'transformToDTO'], $teachers);
    }

    private function transformToDTO(Teacher $teacher): TeacherDTO
    {
        return new TeacherDTO(
            id: $teacher->id,
            name: $teacher->name,
            surname: $teacher->surname,
            phone: $teacher->phone,
            user: $teacher->user?->id ?? null
        );
    }
}
?>