<?php


namespace App\DTOs;

use App\DTOs\UserableAbstract\Userable;

class TeacherDTO extends Userable
{
    private $learning_projects = [];
    private $enrollments = [];

    public int $id;
    public int $phone;
    public string $name;
    public string $surname;

    public function __construct(
        int $id,
        string $name,
        string $surname,
        int $phone,
        int $user_id
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->phone = $phone;
        $this->user_id = $user_id;
    }

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