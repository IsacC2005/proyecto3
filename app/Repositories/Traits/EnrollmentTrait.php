<?php

namespace App\Repositories\Traits;

use App\DTOs\EnrollmentDTO;
use App\Models\Enrollment;

trait EnrollmentTrait
{
    /**
     * ?Metodos privados para transformar los datos de enrollment a DTO
     * 
     * @param array $enrollments
     * @return array<EnrollmentDTO>
     */
    private function transformListDTO(array $enrollments): array
    {
        return array_map([$this, 'transformToDTO'], $enrollments);
    }

    private function transformToDTO(Enrollment $enrollment): EnrollmentDTO
    {
        return new EnrollmentDTO(
            id: $enrollment->id,
            school_year: $enrollment->school_year,
            school_moment: $enrollment->school_moment,
            section: $enrollment->section,
            classroom: $enrollment->classroom,
            teacher_id: $enrollment->teacher_id,
        );
    }
}

?>