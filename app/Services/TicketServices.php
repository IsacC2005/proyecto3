<?php

namespace App\Services;

use App\Constants\TDTO;
use App\DTOs\Details\TicketDetailDTO;
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
use Illuminate\Support\Facades\Response;
use Mockery\Expectation;
use PhpOffice\PhpWord\TemplateProcessor;

class TicketServices
{
    public function __construct(
        private LearningProjectInterface $project,
        private TicketInterface $ticket,
        private StudentInterface $student,
        private GeminiServices $gemini,
        private DatesActual $datesActual
    ) {}



    public function createShowPage(?int $id)
    {
        $teacher_id = Auth::user()->userable_id;



        if (!$teacher_id) {
            $teacher_id = -1;
        }

        $data = [];

        if ($id) {
            $project = $this->project->find($id);
        } else {
            $year = $this->datesActual->getSchoolYearActual();
            $moment = $this->datesActual->getSchoolMomentActual();

            $project = $this->project->findOnDate($year, $moment, $teacher_id);
        }


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


    public function impressTicket(int $id)
    {
        $ticket = $this->ticket->find($id, TDTO::DETAIL);

        return $this->createWord($ticket);
    }


    /**
     * TODO:  Funcion para crear una boleta en formato DOCX  Word
     */

    private function createWord(TicketDetailDTO $ticket)
    {
        $templatePath = storage_path('app/templates/template.docx');

        if (!file_exists($templatePath)) {
            return response()->json(['error' => 'Template file not found at: ' . $templatePath], 500);
        }

        $templateProcessor = new TemplateProcessor($templatePath);

        try {
            // 2. Instanciar el TemplateProcessor
            $templateProcessor = new TemplateProcessor($templatePath);

            // --- DATOS FIJOS PARA PRUEBA (Estos vendrían de tu DB) ---
            $data = [
                'teacherName' => $ticket->teacherName,
                'studentName' => $ticket->studentName,
                'section' => $ticket->section,
                'schoolId' => $ticket->schoolId,
                'schoolYear' => $ticket->schoolYear,
                'projectTitle' => $ticket->projectTitle,
                'schoolMoment' => $ticket->schoolMoment,
                'assistance' => $ticket->assistence,
                'absence' => $ticket->absence,
                'average' => $ticket->average,
                // Texto largo de los logros.
                'content' => $ticket->content,
                'suggestions' => $ticket->suggestions
            ];
            // -------------------------------------------------------------

            foreach ($data as $key => $value) {
                // Aseguramos que los valores sean cadenas. PHPWord requiere cadenas.
                $templateProcessor->setValue($key, (string) $value);
            }

            // NOTA IMPORTANTE: Si la plantilla usa tablas, también puedes clonar filas
            // con TemplateProcessor::cloneRow('marco_tabla', $count), pero para el boletín
            // con estructura fija, los marcadores de posición simples son suficientes.

            // 4. Guardar el documento generado en una ubicación temporal
            $fileName = 'boletin_procesado_' . time() . '.docx';
            $tempPath = tempnam(sys_get_temp_dir(), 'phpword_template');

            $templateProcessor->saveAs($tempPath);

            // 5. Preparar la respuesta de descarga
            $headers = [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'Content-Disposition' => 'attachment;filename="' . $fileName . '"',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ];

            // 6. Forzar la descarga del archivo
            return Response::download($tempPath, $fileName, $headers)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al generar el documento: ' . $e->getMessage()], 500);
        }
    }
}
