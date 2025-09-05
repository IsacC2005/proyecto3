<?php


namespace App\DTOs\Summary;

use App\DTOs\Summary\Userable\UserableInterface;
use App\DTOs\Summary\Userable\UserableTrait;


class TeacherDTO implements UserableInterface, DTOSummary
{

    use UserableTrait;

    private $learningProjectIds = [];
    private $enrollmentIds = [];

    public function __construct(
        public int $id,
        public string $name,
        public string $surname,
        public int $phone,
        public ?int $userId = 0
    ) {}

    public function addLearningProject(int $projectId): void
    {
        $this->learningProjectIds[] = $projectId;
    }

    public function getLearningProjects(): array
    {
        return $this->learningProjectIds;
    }

    public function addEnrollment(int $enrollmentId): void
    {
        $this->enrollmentIds[] = $enrollmentId;
    }

    public function getEnrollments(): array
    {
        return $this->enrollmentIds;
    }

    public function toArray()
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'phone' => $this->phone,
            'user' => $this->user ? $this->user : null, // Convierte el DTO de usuario
            'learningProjects' => '',
            'enrollments' => '',
        ];
    }
}
