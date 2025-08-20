<?php


namespace App\Services;

use App\DTOs\Summary\EnrollmentDTO;
use App\Repositories\Interfaces\EnrollmentInterface;
use App\Repositories\Interfaces\StudentInterface;
use App\Repositories\interfaces\TeacherInterface;

class EnrollmentServices{

    public function __construct(
        private EnrollmentInterface $enrollmentRepository
    ){}
    public function createEnrollment(EnrollmentDTO $enrollment){
        try {
        if($enrollment->school_year === ''){
            $currentYear = date('Y');
            $currentMonth = date('n');
            /**
             * ? Condicion que valida el year escolar, si no esta definido se asigna uno
             * ? teniendo en cuanta la fecha actual, si se esta en el mes 8 al 12 sera el year actual - year siguiente
             * ? y si no es asi y se esta entre el mes 1 y el 7 sera year anterior - year actual
             */
            if ($currentMonth >= 8) {
                $schoolYear = $currentYear . '-' . ($currentYear + 1);
            } else {
                $schoolYear = ($currentYear - 1) . '-' . $currentYear;
            }
            $enrollment->school_year = $schoolYear;
        }

        if($enrollment->school_moment === 0){
            $currentMonth = date('n');

            /**
             * ?Aqui se valida si se asigno un momento academico, si no se asigno un momento academico
             * ? se va a calcular el momento academico indicado en relacion a la fecha actual,
             * ? si la fecha esta entre el mes 8 y 12 el momento academico sera el 1,
             * ? si la fecha esta entre el mes 1 y 3 el momento academico sera el 2,
             * ? si la fecha esta entre el mes 4 y 7 el momento academico sera el 3
             */

            if($currentMonth >= 8 & $currentMonth <= 12)
                {
                    $enrollment->school_moment = 1;
                }
            elseif($currentMonth >= 1 & $currentMonth <= 3){
                $enrollment->school_moment = 2;
            }
            elseif($currentMonth >= 4 & $currentMonth <= 7){
                $enrollment->school_moment = 3;
            }
        }
        $this->enrollmentRepository->create($enrollment);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateEnrollment(){}

    public function searchEnrollment(){}

    public function findEnrollment(){}

    public function deleteEnrollment(){}

    public function addStudentEnrollent(){}

    public function assingTeacherToEnrollment(){}

}

?>
