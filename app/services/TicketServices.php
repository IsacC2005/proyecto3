<?php

namespace App\Services;

use App\DTOs\Summary\TicketDTO;
use App\Jobs\CreateTicketJob;
use App\Models\LearningProjectQualiteStudent;
use App\Repositories\Interfaces\LearningProjectInterface;
use App\Repositories\Interfaces\StudentInterface;
use App\Repositories\Interfaces\TicketInterface;
use GrahamCampbell\ResultType\Error;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
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
        $teacher_id = Auth::user()->userable_id;



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


        $Qualities = '';
        $QualitiesCollection = DB::table('learning_project_qualitie_student as lqs')
            ->join('qualities as q', 'lqs.qualitie_id', '=', 'q.id')

            ->where('lqs.learning_project_id', 4)
            ->where('lqs.student_id', 35741)
            ->pluck('q.name');

        $QualitiesString = $QualitiesCollection->implode(', ');

        $Qualities = $QualitiesString;



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

        $promp = "estas son las cualidades del estudiante: $Qualities ;y estas son sus calificiones: $NoteString";

        $content = $this->gemini->conection($promp);

        //$content = $promp;

        $this->ticket->create(new TicketDTO(
            id: 0,
            average: 'A',
            content: $content,
            suggestions: "",
            learningProjectId: $projectId,
            studentId: $studentId
        ));
    }


    public function createLot(int $projectId)
    {
        $project = $this->project->find($projectId);

        $students = $this->student->findStudentByEnrollment($project->enrollmentId);
        $totalStudents = count($students);

        $cacheKey = 'document_progress_' . $projectId;




        Cache::forget($cacheKey);

        Cache::put($cacheKey, [
            'percentage' => 0,
            'message' => 'Lote iniciado. Despachando tareas individuales...',
            'finished' => false
        ], now()->addHours(1));

        Cache::put($cacheKey . '_completed', 0, now()->addHours(1));

        foreach ($students as $student) {
            CreateTicketJob::dispatch(
                $projectId,
                $student->id,
                $totalStudents,
                $cacheKey,
            );
        }


        Cache::put($cacheKey . '_status', [
            'percentage' => 0,
            'message' => "{$totalStudents} tareas de creación despachadas.",
            'finished' => false
        ], now()->addHours(1));
    }


    public function getAllTicketToProject(int $projectId)
    {
        return $this->ticket->findByLearningProject($projectId);
    }
}
