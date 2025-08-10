<?php

namespace App\Repositories;
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

class TicketRepository extends TransformDTOs implements TicketInterface{

	public function create(TicketDTO $ticket): TicketDTO 
    {
        try {
            $ticketModel = Ticket::create([
                'average' => $ticket->average,
                'content' => $ticket->content,
                'suggestions' => $ticket->suggestions
            ]);

            if(!$ticketModel){
                throw new TicketNotCreatedException();
            }

            return $this->transformToDTO($ticketModel);
        } catch (\Throwable $th) {
            throw new TicketNotCreatedException();
        }
    }



    public function find($id): TicketDTO 
    {
        try {
            $ticketModel = Ticket::find($id);

            if (!$ticketModel) {
                throw new TicketNotFindException();
            }

            return $this->transformToDTO($ticketModel);
        } catch (\Throwable $th) {
            throw new TicketNotFindException();
        }
    }



    public function findAll(): array 
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



    public function findByStudent(int $student_id): array 
    {
        try {
            $ticketModel = Ticket::where('student_id', $student_id)->get();

            if (!$ticketModel) {
                throw new TicketNotFindException();
            }

            return $this->transformListDTO($ticketModel);
        } catch (\Throwable $th) {
            throw new TicketNotFindException();
        }
    }



    public function findByLearningProject(int $project_id): array 
    {
        try {
            $ticketModel = Ticket::where('learning_project_id', $project_id);

            if (!$ticketModel) {
                throw new TicketNotFindException();
            }

            return $this->transformListDTO($ticketModel);
        } catch (\Throwable $th) {
            throw new TicketNotFindException();
        }
    }



    public function update(TicketDTO $ticket): TicketDTO 
    {
        try {
            $ticketModel = Ticket::find($ticket->id);

            if(!$ticketModel){
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

            if(!$ticketModel){
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
            learning_project_id: $model->learning_project->id,
            student_id: $model->student->id
        );
    }
}