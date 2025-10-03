<?php

namespace App\Services;

use App\DTOs\Summary\TicketDTO;
use App\Repositories\Interfaces\LearningProjectInterface;
use App\Repositories\Interfaces\StudentInterface;
use App\Repositories\Interfaces\TicketInterface;
use GrahamCampbell\ResultType\Error;
use Illuminate\Support\Facades\Auth;
use Mockery\Expectation;

class TicketServices
{
    public function __construct(
        private LearningProjectInterface $project,
        private TicketInterface $ticket,
        private StudentInterface $student,
        private GeminiServices $gemini,
        private DatesActual $datesActual
    ) {}



    public function createShowPage()
    {
        $teacher_id = Auth::user()->userable->id;



        if (!$teacher_id) {
            $teacher_id = -1;
        }

        $data = [];

        $year = $this->datesActual->getSchoolYearActual();
        $moment = $this->datesActual->getSchoolMomentActual();

        $project = $this->project->findOnDate($year, $moment, $teacher_id);

        $data["project"] = $project;

        $students = $this->student->findStudentByEnrollment($project->enrollmentId);

        $data["students"] = $students;
        return $data;
    }




    public function create(int $projectId, int $studentId)
    {
        $AllNote = $this->project->getAllNoteStudent($projectId, $studentId);
        $NoteString = "";
        $clases_aplanadas = [];

        foreach ($AllNote as $clase) {
            $clase_string = "Referente Teorico: " . $clase['classTitle'];
            $notas_string = [];

            foreach ($clase['notes'] as $itemTitle => $note) {
                $notas_string[] = $itemTitle . ": " . $note;
            }

            if (!empty($notas_string)) {
                $clase_string .= "; " . implode("; ", $notas_string);
            }

            $clases_aplanadas[] = $clase_string;
        }

        $NoteString = implode("\n", $clases_aplanadas);

        //return $NoteString;

        $content = $this->gemini->conection($NoteString);

        $this->ticket->create(new TicketDTO(
            id: 0,
            average: 'A',
            content: $content,
            suggestions: "",
            learningProjectId: $projectId,
            studentId: $studentId
        ));

        return "todo salio fino crack";
    }


    public function createLot(int $projectId)
    {
        $project = $this->project->find($projectId);

        $students = $this->student->findStudentByEnrollment($project->enrollmentId);

        foreach ($students as $student) {
            $this->create($projectId, $student->id);
        }
    }


    public function getAllTicketToProject(int $projectId)
    {
        return $this->ticket->findByLearningProject($projectId);
    }
}
