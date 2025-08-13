<?php 


namespace App\Services;

use App\Repositories\Interfaces\EnrollmentInterface;
use App\Repositories\Interfaces\StudentInterface;
use App\Repositories\interfaces\TeacherInterface;

class EnrollmentServices{

    public function __construct(
        private EnrollmentInterface $enrollment,
        private StudentInterface $student,
        private TeacherInterface $teacher
    ){}
    public function createEnrollment(){

    }

    public function updateEnrollment(){}

    public function searchEnrollment(){}

    public function findEnrollment(){}

    public function deleteEnrollment(){}

    public function addStudentEnrollent(){}

    public function assingTeacherToEnrollment(){}

}

?>