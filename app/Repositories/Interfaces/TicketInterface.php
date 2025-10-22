<?php

namespace App\Repositories\Interfaces;

use App\DTOs\Details\TicketDetailDTO;
use App\DTOs\Summary\LearningProjectDTO;
use App\DTOs\Summary\StudentDTO;
use App\DTOs\Summary\TicketDTO;

interface TicketInterface
{
    public function create(TicketDTO $ticket): TicketDTO;

    public function find(int $id): TicketDTO | TicketDetailDTO;

    public function findAll(?string $fn = null): array;

    public function findByStudent(int $studentId): array;

    public function findByLearningProject(int $projectId): array;

    public function update(TicketDTO $ticket): TicketDTO;

    public function delete(int $id): void;
}
