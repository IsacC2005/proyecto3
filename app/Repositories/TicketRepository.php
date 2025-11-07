<?php

namespace App\Repositories;

use App\Constants\TDTO;
use App\Repositories\Interfaces\TicketInterface;
use App\DTOs\Summary\TicketDTO;
use App\Exceptions\Ticket\TicketNotCreatedException;
use App\Exceptions\Ticket\TicketNotDeleteException;
use App\Exceptions\Ticket\TicketNotExistException;
use App\Exceptions\Ticket\TicketNotFindException;
use App\Exceptions\Ticket\TicketNotUpdateException;
use App\Models\Ticket;
use App\Repositories\TransformDTOs\TransformDTOs;
use App\DTOs\Summary\DTOSummary;
use Illuminate\Database\Eloquent\Model;
use App\DTOs\Details\DTODetail;
use App\DTOs\Details\TicketDetailDTO;
use App\DTOs\Searches\DTOSearch;

class TicketRepository extends TransformDTOs implements TicketInterface
{

    public function create(TicketDTO $ticket): TicketDTO
    {
        try {
            $ticketModel = Ticket::create([
                'personality' => '',
                'learning_project_id' => $ticket->learningProjectId,
                'student_id' => $ticket->studentId,
                'average' => $ticket->average,
                'content' => $ticket->content,
                'suggestions' => $ticket->suggestions
            ]);

            if (!$ticketModel) {
                throw new TicketNotCreatedException();
            }

            return $this->transformToDTO($ticketModel);
        } catch (\Throwable $th) {
            throw new TicketNotCreatedException($th->getMessage());
        }
    }



    public function find(int $id, ?string $fn = TDTO::SUMMARY): TicketDTO | TicketDetailDTO
    {
        try {
            $ticketModel = Ticket::with('learning_project.teacher', 'learning_project.enrollment', 'student')->find($id);

            if (!$ticketModel) {
                throw new TicketNotFindException();
            }

            return $this->$fn($ticketModel);
        } catch (\Throwable $th) {
            throw new TicketNotFindException($th->getMessage());
        }
    }



    public function findAll(?string $fn = TDTO::SUMMARY): array
    {
        try {
            $ticketModel = Ticket::all();

            if (!$ticketModel) {
                throw new TicketNotFindException();
            }

            return $this->transformListDTO($ticketModel);
        } catch (\Throwable $th) {
            throw new TicketNotFindException();
        }
    }



    public function findByStudent(int $studentId): array
    {
        try {
            $ticketModel = Ticket::with('student')->where('student_id', $studentId)->get();

            if (!$ticketModel) {
                throw new TicketNotFindException();
            }

            return $this->transformListDTO($ticketModel);
        } catch (\Throwable $th) {
            throw new TicketNotFindException();
        }
    }



    public function findByLearningProject(int $projectId): array | null
    {
        try {
            $ticketModel = Ticket::where('learning_project_id', $projectId)->get();

            if (!$ticketModel) {
                return null;
            }

            return $this->transformListDTO($ticketModel);
        } catch (\Throwable $th) {
            throw new TicketNotFindException($th->getMessage());
        }
    }



    public function update(TicketDTO $ticket): TicketDTO
    {
        try {
            $ticketModel = Ticket::find($ticket->id);

            if (!$ticketModel) {
                throw new TicketNotExistException();
            }

            $ticketModel->average = $ticket->average;
            $ticketModel->content = $ticket->content;
            $ticketModel->suggestions = $ticket->suggestions;

            $ticketModel->save();

            return $this->transformToDTO($ticketModel);
        } catch (\Throwable $th) {
            throw new TicketNotUpdateException();
        }
    }



    public function delete($id): void
    {
        try {
            $ticketModel = Ticket::find($id);

            if (!$ticketModel) {
                throw new TicketNotExistException();
            }

            $ticketModel->delete();
        } catch (\Throwable $th) {
            throw new TicketNotDeleteException();
        }
    }

    protected function transformToDTO(Model $model): DTOSummary
    {
        return new TicketDTO(
            id: $model->id,
            average: $model->average,
            content: $model->content,
            suggestions: $model->suggestions,
            studentName: $model->student->name . ' ' . $model->student->surname,
            learningProjectId: $model->learning_project->id,
            studentId: $model->student->id

        );
    }

    protected function transformToDetailDTO(Model $model): TicketDetailDTO
    {
        $project = $model->learning_project;
        $enrollment = $project->enrollment;
        $student = $model->student;

        return new TicketDetailDTO(
            id: $model->id,
            assistence: $model->assistence ?? 0, // TODO: Implementar lógica para obtener asistencias
            absence: $model->absence ?? 0,    // TODO: Implementar lógica para obtener inasistencias
            teacherName: $project->teacher->name . ' ' . $project->teacher->surname,
            section: $enrollment->grade . ' ' . $enrollment->section,
            studentName: $student->name . ' ' . $student->surname,
            schoolId: $student->school_id ?? 'N/A',
            schoolYear: $enrollment->school_year,
            schoolMoment: (string) $project->school_moment,
            average: $model->average,
            content: $model->content,
            suggestions: $model->suggestions,
            projectTitle: $project->title
        );
    }
}
