<?php

namespace App\Repositories;

use App\DTOs\LearningProjectDTO;
use App\DTOs\StudentDTO;
use App\DTOs\TicketDTO;

interface TicketInterface
{
    public function create(TicketDTO $ticket): TicketDTO;

    public function find($id): TicketDTO;

    public function findAll(): array;

    public function findByStudent(StudentDTO $student): array;

    public function findByLearningProject(LearningProjectDTO $learningProject): array;

    public function update(TicketDTO $ticket): TicketDTO;

    public function delete($id): void;
}
?>