<?php


namespace App\Services;

use App\DTOs\Summary\EnrollmentDTO;
use App\Exceptions\Enrollment\EnrollmentNotFindException;
use App\Repositories\Interfaces\EnrollmentInterface;
use App\Repositories\Interfaces\StudentInterface;
use App\Repositories\interfaces\TeacherInterface;
use Error;
use Inertia\Inertia;

class EnrollmentServices
{

    public function __construct(
        private EnrollmentInterface $enrollmentRepository,
        private StudentInterface $studentRepository,
    ) {}




    public function createEnrollment(EnrollmentDTO $enrollment)
    {
        try {
            if ($enrollment->school_year === '') {
                $enrollment->school_year = $this->getSchoolYearActual();
            }

            if ($enrollment->school_moment === 0) {
                $enrollment->school_moment = $this->getSchoolMomentActual();
            }
            $this->enrollmentRepository->create($enrollment);
        } catch (\Throwable $th) {
            throw $th;
        }
    }




    public function findAllEnrollment(?String $f = null): array
    {
        return $this->enrollmentRepository->findAll($f);
    }



    public function addStudentPage(int $enrollment_id)
    {
        $enrollment = $this->enrollmentRepository->find($enrollment_id);
        $data = $this->studentRepository->findStudentByDegree($enrollment->degree - 1);
        return Inertia::render('Enrollment/AddStudent', [
            'enrollment' => $enrollment,
            'students' => $data
        ]);
    }


    public function addStudentSave(int $enrollment_id, int $student_id): void
    {
        $this->enrollmentRepository->addStudent($enrollment_id, $student_id);
    }

    public function findEnrollmentActiveByTeacher(int $teacher_id, ?string $fn = null): EnrollmentDTO
    {
        $school_year = $this->getSchoolYearActual();
        $school_moment = $this->getSchoolMomentActual();

        return $enrollment = $this
            ->enrollmentRepository
            ->findEnrollmentOnSchoolYearAndSchoolMomentByTeacher(
                $teacher_id,
                $school_year,
                $school_moment,
                $fn
            );
    }


    public function updateEnrollment() {}

    public function searchEnrollment() {}

    public function findEnrollment(int $id): EnrollmentDTO
    {
        return $this->enrollmentRepository->find($id);
    }

    public function findEnrollmentByTeacher(int $id_teacher, ?String $f = null): array
    {
        return $this->enrollmentRepository->findByTeacher($id_teacher, $f);
    }

    public function deleteEnrollment() {}

    public function addStudentEnrollent() {}

    public function assignTeacherToEnrollment(int $id_enrollment, int $id_teacher)
    {

        $enrollment = $this->enrollmentRepository->find($id_enrollment);

        $relation = $this->enrollmentRepository
            ->findEnrollmentOnSchoolYearAndSchoolMomentByTeacher(
                $id_teacher,
                $enrollment->school_year,
                $enrollment->school_moment
            );

        if ($relation) {
            throw new EnrollmentNotFindException('El profesor ya esta asignada a otra matricula', 422);
        }

        $rs = $this->enrollmentRepository->assignTeacher($id_enrollment, $id_teacher);

        if ($rs) {
            return 'Se asignó el profesor correctamente.';
        }
    }


    /**
     * TODO: funciones privadas
     */

    private function getSchoolYearActual(): string
    {
        /**
         * ? Esta funcion devuelve el School Year actual
         * ? teniendo en cuanta la fecha actual, si se esta en el mes 8 al 12 sera el year actual - year siguiente
         * ? y si no es asi y se esta entre el mes 1 y el 7 sera year anterior - year actual
         */
        $currentYear = date('Y');
        $currentMonth = date('n');


        if ($currentMonth >= 8) {
            $schoolYear = $currentYear . '-' . ($currentYear + 1);
        } else {
            $schoolYear = ($currentYear - 1) . '-' . $currentYear;
        }
        return $schoolYear;
    }

    private function getSchoolMomentActual(): int
    {
        $currentMonth = date('n');

        $result = -1;
        /**
         * ?Aqui se va a calcular el momento academico indicado en relacion a la fecha actual,
         * ? si la fecha esta entre el mes 8 y 12 el momento academico sera el 1,
         * ? si la fecha esta entre el mes 1 y 3 el momento academico sera el 2,
         * ? si la fecha esta entre el mes 4 y 7 el momento academico sera el 3
         */

        if ($currentMonth >= 8 & $currentMonth <= 12) {
            $result = 1;
        } elseif ($currentMonth >= 1 & $currentMonth <= 3) {
            $result = 2;
        } elseif ($currentMonth >= 4 & $currentMonth <= 7) {
            $result = 3;
        } else {
            throw new Error("Error al intentar calcular el momento escolar actual");
        }
        return $result;
    }
}
