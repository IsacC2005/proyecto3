<?php

namespace App\Services;

use App\Constants\TDTO;
use App\DTOs\Details\TicketDetailDTO;
use App\DTOs\Summary\TicketDTO;
use App\Exceptions\LearningProject\LearningProjectNotExistException;
use App\Jobs\CreateTicketJob;
use App\Models\LearningProjectQualiteStudent;
use App\Repositories\Interfaces\LearningProjectInterface;
use App\Repositories\Interfaces\StudentInterface;
use App\Repositories\Interfaces\TicketInterface;
use GrahamCampbell\ResultType\Error;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Mockery\Expectation;
use PhpOffice\PhpWord\TemplateProcessor;

class TicketServices
{
    public function __construct(
        private LearningProjectInterface $project,
        private TicketInterface $ticket,
        private StudentInterface $student,
        private GeminiServices $gemini,
        private DatesActual $datesActual,
        private CleanText $cleanText
    ) {}

    public function show(int $id, int $studentId): InertiaResponse
    {
        $data = $this->ticket->find($id);

        $student = $this->student->findStudentById($studentId);


        return Inertia::render('Ticket/ShowReportNote/ShowReportNote', [
            'data' => $data ?? [],
            'student' => $student
        ]);
    }


    public function createShowPage(?int $id): InertiaResponse | RedirectResponse
    {
        $teacher_id = $this->getTeacherIdOrFail();

        if ($id) {
            $project = $this->project->find($id);
        } else {
            $year = $this->datesActual->getSchoolYearActual();
            $moment = $this->datesActual->getSchoolMomentActual();

            $project = $this->project->findOnDate($year, $moment, $teacher_id);
        }

        if (!$project) {
            return redirect()->route('learning-project.index');
        }

        $students = $this->student->findStudentByEnrollment($project->enrollmentId);

        return Inertia::render('Ticket/Create', [
            'project' => $project,
            'students' => $students
        ]);
    }




    public function create(int $projectId, int $studentId)
    {

        $exits  = $this->ticket->findByStudentAndProject($studentId, $projectId);

        if ($exits) {
            /**
             * @param TicketDTO | null
             */
            $this->recreateContent($exits->id);
            return;
        }

        $promp = $this->createPromp($studentId, $projectId);
        $content = $this->createConent($promp);

        $this->ticket->create(new TicketDTO(
            id: 0,
            average: 'A',
            content: $this->cleanText->clean($content),
            suggestions: "",
            studentName: "",
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


        // $data = Cache::get('ia_pendientes_list', ['data' => []]);


        //$this->delete();

        foreach ($students as $student) {

            // $data['data'][] = [
            //     'projectId' => $project->id,
            //     'studentId' => $student->id,
            //     'totalStudents' => $totalStudents,
            //     'cacheKey' => $cacheKey,
            // ];

            CreateTicketJob::dispatch(
                $projectId,
                $student->id,
                $totalStudents,
                $cacheKey,
            );
        }


        // Cache::put('ia_pendientes_list', $data, now()->addDays(7));

        Cache::put($cacheKey . '_status', [
            'percentage' => 0,
            'message' => "{$totalStudents} tareas de creación despachadas.",
            'finished' => false
        ], now()->addHours(1));
    }


    public function getAllTicketToProject(?int $projectId = null): InertiaResponse | RedirectResponse
    {

        $teacher_id = $this->getTeacherIdOrFail();
        $project = null;

        if ($projectId) {
            $project = $this->project->find($projectId);
        } else {
            $year = $this->datesActual->getSchoolYearActual();
            $moment = $this->datesActual->getSchoolMomentActual();

            $project = $this->project->findOnDate($year, $moment, $teacher_id);
        }

        if (!$project) {
            return redirect()->route('learning-project.index');
        }

        $data = $this->ticket->findByLearningProject($projectId);

        if (!$data) {
            activity('No se encontro ningun boletin para el proyecto de aprendizaje ' . $projectId)
                ->causedBy(Auth::user());
            return redirect()->route('learning-project.index');
        }

        return Inertia::render('Ticket/ListTicket', [
            'ReportsNotes' => $data,
            'project' => $project
        ]);
    }



    public function recreateContent(int $id)
    {
        $ticket = $this->ticket->find($id);

        $promp = $this->createPromp($ticket->studentId, $ticket->learningProjectId);
        $content = $this->createConent($promp);

        $ticket->content = $this->cleanText->clean($content);

        $this->ticket->update($ticket);

        $data = $this->ticket->find($id);

        $student = $this->student->findStudentById($data->studentId);

        return redirect()->back()
            ->with('success', '¡El ticket ha sido actualizado exitosamente!');
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
        $templatePath = resource_path('templates/template.docx');

        if (!file_exists($templatePath)) {
            return response()->json(['error' => 'Template file not found at: ' . $templatePath], 500);
        }

        $templateProcessor = new TemplateProcessor($templatePath);

        try {
            $templateProcessor = new TemplateProcessor($templatePath);

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
                'content' => $ticket->content,
                'suggestions' => $ticket->suggestions
            ];

            foreach ($data as $key => $value) {
                $templateProcessor->setValue($key, (string) $value);
            }

            $fileName = $ticket->studentName . '_boletin_'  . date('Y-m-d') . '.docx';
            $tempPath = tempnam(sys_get_temp_dir(), 'phpword_template');

            $templateProcessor->saveAs($tempPath);

            $headers = [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'Content-Disposition' => 'attachment;filename="' . $fileName . '"',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ];

            return Response::download($tempPath, $fileName, $headers)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al generar el documento: ' . $e->getMessage()], 500);
        }
    }


    private function createPromp(int $studentId, int $projectId): string
    {
        $AllNote = $this->project->getAllNoteStudentLAndPL($projectId, $studentId);


        $Qualities = '';
        $QualitiesCollection = DB::table('learning_project_qualitie_student as lqs')
            ->join('qualities as q', 'lqs.qualitie_id', '=', 'q.id')

            ->where('lqs.learning_project_id', $projectId)
            ->where('lqs.student_id', $studentId)
            ->pluck('q.name');

        $QualitiesString = $QualitiesCollection->implode(', ');

        $Qualities = $QualitiesString;



        $NoteString = "";
        $clases_aplanadas = [];

        foreach ($AllNote as $clase) {
            $clase_string = ''; // "Referente Teorico: " . $clase['classTitle'];
            $notas_string = [];

            foreach ($clase['notes'] as $itemTitle => $note) {
                $notas_string[] = $itemTitle;
            }

            if (!empty($notas_string)) {
                $clase_string .=  implode(". ", $notas_string);
            }

            $clases_aplanadas[] = $clase_string;
        }

        $NoteString = implode("\n", $clases_aplanadas);

        $promp = "**Cualidades:** $Qualities . **Logros:** $NoteString";

        return $promp;
    }



    private function createConent(string $promp): string
    {
        $content = $this->gemini->conection($promp);
        return $content;
    }



    public function update(TicketDTO $ticket)
    {
        $this->ticket->update($ticket);
    }



    private function getTeacherIdOrFail(): int
    {
        $user = Auth::user();

        $teacher = $user->getTeacherEntity();

        if (is_null($teacher)) {
            activity('Usuario sin profesor asociado, intentando ver proyectos de aprendizaje.')
                ->causedBy($user);

            throw new \Exception('Este usuario no tiene un profesor asociado.');
        }

        return $teacher->id;
    }
}
