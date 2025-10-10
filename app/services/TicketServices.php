<?php

namespace App\Services;

use App\DTOs\Summary\TicketDTO;
use App\Jobs\CreateTicketJob;
use App\Repositories\Interfaces\LearningProjectInterface;
use App\Repositories\Interfaces\StudentInterface;
use App\Repositories\Interfaces\TicketInterface;
use GrahamCampbell\ResultType\Error;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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
        $totalStudents = count($students);

        $cacheKey = 'document_progress_' . $projectId;




        Cache::forget($cacheKey); // Limpia el estado anterior

        // Inicializa el estado para la barra de progreso
        Cache::put($cacheKey, [
            'percentage' => 0,
            'message' => 'Lote iniciado. Despachando tareas individuales...',
            'finished' => false
        ], now()->addHours(1));

        // Inicializa el contador de documentos completados.
        Cache::put($cacheKey . '_completed', 0, now()->addHours(1));

        foreach ($students as $i => $student) {
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


        // Cache::forget($cacheKey);

        // Cache::put($cacheKey, [
        //     'percentage' => 0,
        //     'message' => 'Preparando la tarea de creación masiva...',
        //     'finished' => false
        // ], now()->addHours(1));


        // $count = 0;

        // foreach ($students as $student) {
        //     $count++;

        //     $this->create($projectId, $student->id);

        //     $statusDescription = "$count documentos de $totalStudents";
        //     $progressPercent = round(($count / $totalStudents) * 100);

        //     Cache::put($cacheKey, [
        //         'percentage' => $progressPercent,
        //         'message' => $statusDescription,
        //         'finished' => false
        //     ], now()->addHours(1));
        // }
        // Cache::put($cacheKey, [
        //     'percentage' => 100,
        //     'message' => '¡Lote de documentos completado!',
        //     'finished' => true
        // ], now()->addHours(1));
    }


    public function getAllTicketToProject(int $projectId)
    {
        return $this->ticket->findByLearningProject($projectId);
    }
}
