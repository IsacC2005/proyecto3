<?php


namespace App\DTOs;

use App\DTOs\UserableAbstract\Userable;

class TeacherDTO extends Userable
{
    private $learning_projects = [];
    private $enrollments = [];

    public function __construct(
        public int $id,
        public string $name,
        public string $surname,
        public string $phone,
        public ?UserDTO $user = null,
    ) {}


    public function addLearningProject(LearningProjectDTO $learningProject): void
    {
        $this->learning_projects[] = $learningProject;
    }

    public function getLearningProjects(): array
    {
        return $this->learning_projects;
    }

    public function addEnrollment(EnrollmentDTO $enrollment): void
    {
        $this->enrollments[] = $enrollment;
    }

    public function getEnrollments(): array
    {
        return $this->enrollments;
    }
}
?>