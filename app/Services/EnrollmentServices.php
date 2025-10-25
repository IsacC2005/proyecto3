<?php


namespace App\Services;

use App\Constants\TDTO;
use App\DTOs\Summary\EnrollmentDTO;
use App\Exceptions\Enrollment\EnrollmentNotCreatedException;
use App\Exceptions\Enrollment\EnrollmentNotFindException;
use App\Factories\EnrollmentFactory;
use App\Repositories\Interfaces\EnrollmentInterface;
use App\Repositories\Interfaces\StudentInterface;
use App\Repositories\interfaces\TeacherInterface;
use Error;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class EnrollmentServices
{

    public function __construct(
        private EnrollmentInterface $enrollmentRepository,
        private StudentInterface $studentRepository,
        private DatesActual $dates
    ) {}




    public function createEnrollment(EnrollmentDTO $enrollment)
    {
        try {
            if ($enrollment->schoolYear === '') {
                $enrollment->schoolYear = $this->dates->getSchoolYearActual();
            }

            $exist = $this->enrollmentRepository->existEnrollmentSecctionAndSchoolYear(
                $enrollment->grade,
                $enrollment->section,
                $enrollment->schoolYear
            );

            if ($exist) {
                throw new EnrollmentNotCreatedException('Esta seccion ya existe :))');
            }

            $this->enrollmentRepository->create($enrollment);
        } catch (\Throwable $th) {
            throw $th;
        }
    }




    public function createLot(array $lot)
    {
        $schooleYear = $this->dates->getSchoolYearActual();

        foreach ($lot as $item) {
            $data = EnrollmentFactory::fromArray($item);

            $data->schoolYear = $schooleYear;

            if (!$this->enrollmentRepository->existEnrollmentSecctionAndSchoolYear(
                $data->grade,
                $data->section,
                $data->schoolYear
            )) {
                $this->createEnrollment($data);
            }
        }
    }




    public function showEnrollments(?string $schoolYear = null)
    {
        if (!$schoolYear) {
            $schoolYear = $this->dates->getSchoolYearActual();
        }

        /**
         * @var Array<EnrollmentDetailDTO>
         */
        $sections = $this->findEnrollmentByYearSchool($schoolYear);

        return Inertia::render('Enrollment/ListSections', [
            'sections' => array_map(function ($section) {
                return $section->toArray();
            }, $sections),
            'schoolYear' => $schoolYear
        ]);
    }


    private function findEnrollmentByYearSchool(?String $schoolYear = null)
    {
        if (strlen($schoolYear) != 9) {
            throw new \InvalidArgumentException('El formato del momento es inválido.');
        }

        return $this->enrollmentRepository->findByYearSchool($schoolYear, TDTO::DETAIL);
    }


    public function addStudentPage(int $enrollmentId)
    {
        $section = $this->enrollmentRepository->find($enrollmentId);
        $data = $this->studentRepository->findStudentByGrade($section->grade - 1, true, $enrollmentId);

        return Inertia::render('Enrollment/AddStudent', [
            'section' => $section->toArray(),
            'pagination' => $data
        ]);
    }


    public function addStudentSave(int $enrollmentId, int $studentId): void
    {
        $enrollment = $this->enrollmentRepository->find($enrollmentId);
        $exist = $this->enrollmentRepository->studentItsAddInGrade($enrollment->grade, $studentId);
        if ($exist) {
            throw new EnrollmentNotCreatedException('El estudiante ya esta en una matricula', 422);
        }
        $this->enrollmentRepository->addStudent($enrollmentId, $studentId);
    }

    public function findEnrollmentActiveByTeacher(int $teacherId, ?string $fn = TDTO::SUMMARY): EnrollmentDTO | null
    {
        $schoolYear = $this->dates->getSchoolYearActual();
        //$schoolMoment = $this->dates->getSchoolMomentActual();

        $enrollment = $this
            ->enrollmentRepository
            ->findEnrollmentOnSchoolYearByTeacher(
                $teacherId,
                $schoolYear,
                $fn
            );

        if (!$enrollment) {
            activity('Seccion no encontrada')
                ->causedBy(Auth::user())
                ->log("El profesor $teacherId intento buscar una seccion del $schoolYear pero no se encontron ninguna");

            return null;
        }

        return $enrollment;
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
}
