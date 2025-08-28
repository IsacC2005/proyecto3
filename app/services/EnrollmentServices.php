<?php


namespace App\Services;

use App\Constants\TDTO;
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
            if ($enrollment->schoolYear === '') {
                $enrollment->schoolYear = $this->getSchoolYearActual();
            }

            if ($enrollment->schoolMoment === 0) {
                $enrollment->schoolMoment = $this->getSchoolMomentActual();
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


    public function findEnrollmentByYearSchool(?String $year = null)
    {
        if (strlen($year) != 9) {
            throw new \InvalidArgumentException('El formato del momento es inválido.');
        }

        $data = $this->enrollmentRepository->findByYearSchool($year, TDTO::DETAIL);
        return Inertia::render('Enrollment/ListSections', [
            'sections' => array_map(function ($item) {
                return $item->toArray();
            }, $data),
            'message' => "Todas las matriculas del $year"

        ]);
    }


    public function addStudentPage(int $enrollmentId)
    {
        $enrollment = $this->enrollmentRepository->find($enrollmentId);
        $data = $this->studentRepository->findStudentByDegree($enrollment->grade - 1);
        return Inertia::render('Enrollment/AddStudent', [
            'enrollment' => $enrollment,
            'students' => $data
        ]);
    }


    public function addStudentSave(int $enrollmentId, int $studentId): void
    {
        $this->enrollmentRepository->addStudent($enrollmentId, $studentId);
    }

    public function findEnrollmentActiveByTeacher(int $teacherId, ?string $fn = null): EnrollmentDTO
    {
        $schoolYear = $this->getSchoolYearActual();
        $schoolMoment = $this->getSchoolMomentActual();

        return $enrollment = $this
            ->enrollmentRepository
            ->findEnrollmentOnSchoolYearAndSchoolMomentByTeacher(
                $teacherId,
                $schoolYear,
                $schoolMoment,
                $fn
            );
    }


    public function updateEnrollment() {}

    public function searchEnrollment() {}

    public function findEnrollment(int $id): EnrollmentDTO
    {
        return $this->enrollmentRepository->find($id);
    }

    public function findEnrollmentByTeacher(int $teacherId, ?String $f = null): array
    {
        return $this->enrollmentRepository->findByTeacher($teacherId, $f);
    }

    public function deleteEnrollment() {}

    public function addStudentEnrollent() {}

    public function assignTeacherToEnrollment(int $enrollmentId, int $teacherId)
    {

        $enrollment = $this->enrollmentRepository->find($enrollmentId);

        $relation = $this->enrollmentRepository
            ->findEnrollmentOnSchoolYearAndSchoolMomentByTeacher(
                $teacherId,
                $enrollment->schoolYear,
                $enrollment->schoolMoment
            );

        if ($relation) {
            throw new EnrollmentNotFindException('El profesor ya esta asignada a otra matricula', 422);
        }

        $rs = $this->enrollmentRepository->assignTeacher($enrollmentId, $teacherId);

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
