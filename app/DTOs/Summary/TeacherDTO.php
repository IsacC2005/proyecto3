<?php


namespace App\DTOs\Summary;

use App\DTOs\Summary\Userable\UserableInterface;
use App\DTOs\Summary\Userable\UserableTrait;


class TeacherDTO implements UserableInterface
{

    use UserableTrait;

    private $learning_project_ids = [];
    private $enrollment_ids = [];

    public function __construct(
        public int $id,
        public string $name,
        public string $surname,
        public int $phone,
        public ?int $user_id = 0
    ) {}

    public function addLearningProject(int $project_id): void
    {
        $this->learning_project_ids[] = $project_id;
    }

    public function getLearningProjects(): array
    {
        return $this->learning_project_ids;
    }

    public function addEnrollment(int $enrollment_id): void
    {
        $this->enrollment_ids[] = $enrollment_id;
    }

    public function getEnrollments(): array
    {
        return $this->enrollment_ids;
    }
}
