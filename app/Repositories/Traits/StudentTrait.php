<?php

namespace App\Repositories\Traits;

use App\DTOs\Summary\StudentDTO;
use App\Models\Student;

trait StudentTrait
{
    private function transformListDTO(array $students): array
    {
        return array_map([$this, 'transformToDTO'], $students);
    }

    private function transformToDTO(Student $student): StudentDTO
    {
        $representative = $student->representative;
        return new StudentDTO(
            id: $student->id,
            degree: $student->degree,
            name: $student->name,
            surname: $student->surname,
            representative_id: $representative->id
        );
    }
}
?>