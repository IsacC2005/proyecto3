<?php

namespace App\DTOs\Searches;

use App\DTOs\Searches\Userable\UserableSearchInterface;
use App\DTOs\Searches\Userable\UserableSearchTrait;


class TeacherSearchDTO implements UserableSearchInterface
{

    use UserableSearchTrait;

    private $learning_project_ids = [];
    private $enrollment_ids = [];

    public int $id;
    public int $phone;
    public string $name;
    public string $surname;

    public function __construct(
        ?int $id = null,
        ?string $name = null,
        ?string $surname = null,
        ?int $phone = null,
        ?int $user_id = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->phone = $phone;
        $this->user_id = $user_id;
    }

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
