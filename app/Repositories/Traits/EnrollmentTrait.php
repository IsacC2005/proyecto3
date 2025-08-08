<?php

namespace App\Repositories\Traits;

use App\DTOs\Details\EnrollmentDetailDTO;
use App\DTOs\Details\TeacherDetailDTO;
use App\DTOs\Details\UserDetailDTO;
use App\DTOs\Summary\EnrollmentDTO;
use App\Models\Enrollment;
use App\Models\Teacher;
use Illuminate\Support\Collection;

trait EnrollmentTrait
{
    /**
     * ?Metodos privados para transformar los datos de enrollment a DTO
     * 
     * @param Collection $enrollments
     * @return array<EnrollmentDTO>
     */
    private function transformListDTO(Collection $enrollments): array
    {
        $function = "transformToDTO";
        return $enrollments->map(function ($enrollment) use ($function){
            return $this->{$function}($enrollment);
        })->toArray();
    }

    private function transformToDTO(Enrollment $enrollment): EnrollmentDTO
    {
        return new EnrollmentDTO(
            id: $enrollment->id,
            school_year: $enrollment->school_year,
            school_moment: $enrollment->school_moment,
            degree: $enrollment->degree,
            section: $enrollment->section,
            classroom: $enrollment->classroom,
            teacher_id: $enrollment->teacher_id,
        );
    }

    private function transformToDTOSearch() {}

    private function transformToDTODetail(Enrollment $enrollment): EnrollmentDetailDTO{
        $teacherConsult = $enrollment->teacher();

        $teacher = $enrollment->teacher;

        $user = $teacher->user; 

        $userDTO = new UserDetailDTO(
            id: $user->id,
            name: $user->name,
            email: $user->email,
            password: $user->password
        );

        $teacherDTO = new TeacherDetailDTO(
            id: $teacher->id,
            name: $teacher->name,
            surname: $teacher->surname,
            phone: $teacher->phone,
            user: $userDTO
        );

        return new EnrollmentDetailDTO(
            id: $enrollment->id,
            school_year: $enrollment->school_year,
            school_moment: $enrollment->school_moment,
            degree: $enrollment->degree,
            section: $enrollment->section,
            classroom: $enrollment->classroom,
            teacher: $teacherDTO,
        );
        
    }
}

?>