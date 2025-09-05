<?php

namespace App\Services;

use Error;

class DatesActual
{
    public function getSchoolYearActual(): string
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

    public function getSchoolMomentActual(): int
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
