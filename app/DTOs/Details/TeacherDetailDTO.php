<?php


namespace App\DTOs\Details;

use App\DTOs\Details\Userable\UserableDetailInterface;
use App\DTOs\Details\Userable\UserableDetailTrait;


class TeacherDetailDTO implements UserableDetailInterface
{

    use UserableDetailTrait;

    private $learning_projects = [];
    private $enrollments = [];

    public function __construct(
        public int $id,
        public string $name,
        public string $surname,
        public int $phone,
        public ?UserDetailDTO $user = null
    ) {}

    public function addLearningProject(LearningProjectDetailDTO $learningProject): void
    {
        $this->learning_projects[] = $learningProject;
    }

    public function getLearningProjects(): array
    {
        return $this->learning_projects;
    }

    public function addEnrollment(EnrollmentDetailDTO $enrollment): void
    {
        $this->enrollments[] = $enrollment;
    }

    public function getEnrollments(): array
    {
        return $this->enrollments;
    }
}
