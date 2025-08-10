<?php

namespace App\Repositories\Interfaces;

use App\DTOs\Summary\LearningProjectDTO;
use App\DTOs\Summary\StudentDTO;
use App\DTOs\Summary\TicketDTO;

interface TicketInterface
{
    public function create(TicketDTO $ticket): TicketDTO;

    public function find($id): TicketDTO;

    public function findAll(): array;

    public function findByStudent(int $student_id): array;

    public function findByLearningProject(int $project_id): array;

    public function update(TicketDTO $ticket): TicketDTO;

    public function delete($id): void;
}
?>