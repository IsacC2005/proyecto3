<?php

namespace App\Repositories;

use App\Constants\TDTO;
use App\DTOs\Summary\LearningProjectDTO;
use App\Models\LearningProject;
use App\Exceptions\LearningProject\LearningProjectNotCreatedException;
use App\Exceptions\LearningProject\LearningProjectNotDeleteException;
use App\Exceptions\LearningProject\LearningProjectNotExistException;
use App\Exceptions\LearningProject\LearningProjectNotFindException;
use App\Exceptions\LearningProject\LearningProjectNotUpdateException;
use App\Exceptions\Teacher\TeacherNotExistException;
use App\Models\Enrollment;
use App\Models\Teacher;
use App\Repositories\Interfaces\LearningProjectInterface;
use App\Repositories\TransformDTOs\TransformDTOs;
use App\DTOs\Summary\DTOSummary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\DTOs\Details\DTODetail;
use App\DTOs\Details\LearningProjectDetailDTO;
use App\DTOs\Details\NotesDetailDTO;
use App\DTOs\Searches\DTOSearch;
use App\DTOs\Summary\EnrollmentDTO;
use App\Factories\DailyClassFactory;
use App\Factories\EnrollmentFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use function PHPUnit\Framework\isEmpty;

class LearningProjectRepository extends TransformDTOs implements LearningProjectInterface
{

    public function create(LearningProjectDetailDTO $learningProject): LearningProjectDTO
    {
        try {
            $projectModel = LearningProject::create([
                'title' => $learningProject->title,
                'content' => $learningProject->content,
                'school_moment' => $learningProject->schoolMoment,
                'teacher_id' => $learningProject->teacher->id,
                'enrollment_id' => $learningProject->enrollment->id,
            ]);

            if (!$projectModel) {
                throw new LearningProjectNotCreatedException();
            }

            return $this->transformToDTO($projectModel);
        } catch (\Throwable $th) {
            throw new LearningProjectNotCreatedException($th->getMessage());
        }
    }



    public function existProjectForTeacher(int $project_id, int $teacher_id): bool
    {
        $rs = $this->existProject($project_id);

        if (!$rs) {
            throw new LearningProjectNotExistException();
        }

        return LearningProject::where('id', $project_id)->where('teacher_id', $teacher_id)->exists();
    }



    public function existProject(int $id): bool
    {
        return LearningProject::where('id', $id)->exists();
    }


    public function existProjectByTeacheByYearByMoment(int $teacherId, int $enrollmentId, int $schoolMoment): bool
    {
        return (bool) LearningProject::where('teacher_id', $teacherId)
            ->where('enrollment_id', $enrollmentId)
            ->where('school_moment', $schoolMoment)
            ->exists();
    }



    public function find(int $id, ?string $fn = TDTO::SUMMARY): LearningProjectDTO | LearningProjectDetailDTO
    {
        try {
            $project = LearningProject::find($id);
            if (!$project) {
                throw new LearningProjectNotFindException();
            }

            return $this->$fn($project);
        } catch (\Throwable $th) {
            throw new LearningProjectNotFindException($th->getMessage());
        }
    }



    public function findAll(?string $fn = null): array
    {
        try {
            $projects = LearningProject::all();
            if (!$projects) {
                throw new LearningProjectNotFindException();
            }
            return $this->transformListDTO($projects);
        } catch (\Throwable $th) {
            throw new LearningProjectNotFindException();
        }
    }




    public function findByEnrollment(int $enrollmentId): array
    {
        try {
            $project = LearningProject::where('enrollment_id', $enrollmentId)->get();

            if (!$project) {
                return [];
            }

            return $this->transformListDTO($project);
        } catch (\Throwable $th) {
            throw new LearningProjectNotFindException($th->getMessage());
        }
    }



    public function findByEnrollmentAndMoment(int $enrollmentId, int $moment): LearningProjectDTO | null
    {
        try {
            $project = LearningProject::where('enrollment_id', $enrollmentId)
                ->where('school_moment', $moment)->first();

            if (!$project) {
                //throw new \Exception($enrollmentId . ' ' . $moment);
                return null;
            }

            return $this->transformToDTO($project);
        } catch (\Throwable $th) {
            throw new LearningProjectNotFindException($th->getMessage());
        }
    }



    public function findByTeacher(int $teacherId, ?string $fn = null): array
    {
        try {

            $projects = LearningProject::where('teacher_id', $teacherId)->get();

            return $this->transformListDTO($projects, $fn);
        } catch (\Throwable $th) {
            throw new LearningProjectNotFindException($th->getMessage());
        }
    }



    public function findOnDate(string $schoolYear, string $schoolMoment, ?int $teacherId = null, ?string $fn = TDTO::SUMMARY): LearningProjectDTO | LearningProjectDetailDTO | null
    {
        try {
            //return null;

            $japecoUrl = env('JAPECO_URL');

            $response = Http::get("$japecoUrl/api/section/find/school-year-and-teacher-id", [
                'schoolYear' => "2025-2026",
                'teacherId' => 72
            ]);

            if (!$response->successful()) {
                return null;
            }

            $apiData = $response->json();

            if (!isEmpty($apiData['data'])) {
                return null;
            }

            $enrollment = $apiData['data'];

            $project = LearningProject::where('enrollment_id', $enrollment['id'])
                ->where('school_moment', $schoolMoment)
                ->where('teacher_id', $teacherId)->first();

            if (!$project) {
                return null;
            }
            return $this->$fn($project);
        } catch (\Throwable $th) {
            throw $th;
        }
    }



    public function countStudents(int $projectId): int
    {
        $project = LearningProject::with(['enrollment.students'])->find($projectId);
        return $project->enrollment->students->length;
    }




    public function getAllEvaluationByProject(int $projectId): array
    {

        // 1. CARGA DE DATOS LOCALES (BD)
        // Se utiliza Eager Loading selectivo para las clases y los ítems.
        // La carga se detiene antes de la relación 'students' fallida.
        $project = LearningProject::with([
            // Seleccionamos solo las columnas que necesitamos para el rendimiento
            'daily_classes:id,learning_project_id,title',
            'daily_classes.evaluation_items:id,daily_class_id,title',
        ])->find($projectId);

        if (!$project) {
            return [];
        }

        // --- 2. CARGA DE NOTAS DE LA TABLA PIVOTE (DB::table) ---

        // Obtener todos los IDs de los ítems de evaluación necesarios para la consulta
        $evaluationItemIds = $project->daily_classes
            ->flatMap(fn($class) => $class->evaluation_items->pluck('id'))
            ->unique()
            ->values()
            ->toArray();

        // Consultar la tabla pivote directamente, evitando el modelo de estudiante
        // y agrupando el resultado por el ID del ítem de evaluación.
        $notesData = DB::table('evaluation_item_student')
            ->select('evaluation_item_id', 'student_id', 'note')
            ->whereIn('evaluation_item_id', $evaluationItemIds)
            ->get()
            ->groupBy('evaluation_item_id');


        // 3. CARGA DE ESTUDIANTES EXTERNOS (API)
        $japecoUrl = env('JAPECO_URL');
        $response = Http::get("{$japecoUrl}/api/student/to-section/{$project->enrollment_id}");

        if (!$response->successful()) {
            // En un caso real, podrías querer registrar este error
            return [];
        }

        $apiData = $response->json();

        // Crear una colección indexada por ID para una búsqueda eficiente O(1)
        $students = collect($apiData['data'])->keyBy('id');

        // 4. INICIALIZACIÓN DE LA ESTRUCTURA FINAL DE DATOS

        // Inicializar el array de estudiantes con la estructura final requerida
        $finalStudents = $students->map(function ($student) {
            return [
                'id' => $student['id'],
                'name' => trim("{$student['name']} {$student['surname']}"), // Nombre completo
                'notesByReferent' => [] // Estructura donde se almacenarán las notas
            ];
        });

        // 5. CONSOLIDACIÓN DE NOTAS (Fusionar BD local con Estudiantes de API)

        // Recorrer la estructura de clases e ítems para asignar las notas
        foreach ($project->daily_classes as $dailyClass) {
            foreach ($dailyClass->evaluation_items as $evaluationItem) {
                $itemId = $evaluationItem->id;

                // Verificar si hay notas en el set obtenido del Query Builder
                if (isset($notesData[$itemId])) {

                    foreach ($notesData[$itemId] as $noteEntry) {

                        $studentId = (int) $noteEntry->student_id; // Asegurar el tipo para la clave

                        // Solo si el estudiante existe en la lista de la API
                        if ($finalStudents->has($studentId)) {
                            // OBTENEMOS el elemento (una copia)
                            $studentData = $finalStudents->get($studentId);

                            $dailyClassId = $dailyClass->id;

                            // 2. MODIFICAR LA COPIA
                            // Inicializar el array de la clase si no existe
                            if (!isset($studentData['notesByReferent'][$dailyClassId])) {
                                $studentData['notesByReferent'][$dailyClassId] = [];
                            }

                            // Asignar la nota a la copia
                            $studentData['notesByReferent'][$dailyClassId][$itemId] = $noteEntry->note;

                            // 3. ACTUALIZAR LA COLECCIÓN ORIGINAL con la copia modificada
                            $finalStudents->put($studentId, $studentData);
                        }
                    }
                }
            }
        }

        // 6. CREACIÓN DE LA ESTRUCTURA DE CLASES/INDICADORES

        // Se usa el método map de las colecciones de Laravel para un código más limpio
        $classes = $project->daily_classes->map(function ($dailyClass) {
            return [
                'id' => $dailyClass->id,
                'title' => $dailyClass->title,
                'indicators' => $dailyClass->evaluation_items->map(function ($evaluationItem) {
                    return [
                        'id' => $evaluationItem->id,
                        'name' => $evaluationItem->title
                    ];
                })->toArray()
            ];
        })->toArray();


        // 7. RESPUESTA FINAL
        return [
            'projectId' => $project->id,
            'classes' => $classes,
            // Usar values() para convertir la colección indexada en un array secuencial
            'students' => $finalStudents->values()->toArray()
        ];
    }




    public function getAllNoteStudent(int $projectId, int $studentId): array
    {
        $project = LearningProject::find($projectId);

        $classes = $project->daily_classes;

        $AllNote = [];

        foreach ($classes as $class) {
            $evaluation_items = $class->evaluation_items()
                ->whereHas('students', function ($query) use ($studentId) {
                    $query->where('students.id', $studentId);
                })
                ->with(['students' => function ($query) use ($studentId) {
                    $query->where('students.id', $studentId)->withPivot('note');
                }])
                ->get();

            $notes = [];
            foreach ($evaluation_items as $item) {
                $student = $item->students->first();
                if ($student) {
                    $notes[$item->title] = $student->pivot->note;
                }
            }

            $AllNote[] = [
                'classTitle' => $class->title,
                'notes' => $notes
            ];
        }
        return $AllNote;
    }





    public function search(LearningProjectDTO $learningProject): array
    {
        return ['agrega', 'algo'];
    }



    public function update(LearningProjectDTO $learningProject): LearningProjectDTO
    {
        try {
            $projectModel = LearningProject::find($learningProject->id);
            if (!$projectModel) {
                throw new LearningProjectNotFindException();
            }

            $projectModel->title = $learningProject->title;
            $projectModel->content = $learningProject->content;

            if ($learningProject->teacherId & $learningProject->enrollmentId != 0) {
                $teacher = Teacher::find($learningProject->teacherId);
                if ($teacher) {
                    $projectModel->teacher()->associate($teacher);
                }
            }

            if ($learningProject->enrollmentId & $learningProject->enrollmentId !== 0) {
                $enrollment = Enrollment::find($learningProject->enrollmentId);
                if ($enrollment) {
                    $projectModel->enrollment()->associate($enrollment);
                }
            }

            $projectModel->save();

            return $this->transformToDTO($projectModel);
        } catch (\Throwable $th) {
            throw new LearningProjectNotUpdateException();
        }
    }




    public function delete($id): void
    {
        try {
            $project = LearningProject::find($id);
            if (!$project) {
                throw new LearningProjectNotExistException();
            }
            $project->delete();
        } catch (\Throwable $th) {
            throw new LearningProjectNotDeleteException($th->getMessage());
        }
    }

    protected function transformToDTO(Model $model): LearningProjectDTO
    {
        //$teacher = $model->teacher;
        //$enrollment = $model->enrollment;
        //       $teacherDTO = TeacherTrait::transformToDTO($teacher) ?? null;

        return new LearningProjectDTO(
            id: $model->id,
            title: $model->title,
            content: $model->content,
            schoolMoment: $model->school_moment,
            teacherId: $model->teacher_id,
            enrollmentId: $model->enrollment_id
        );
    }

    protected function transformToDetailDTO(Model $model): DTODetail
    {
        $japecoUrl = env('JAPECO_URL');

        //        throw new \ErrorException($model->enrollment_id . "asdfaf");

        $response = Http::get("$japecoUrl/api/section/show/{$model->enrollment_id}");

        $enrollment = null;

        if ($response->successful()) {

            $apiData = $response->json();

            $enrollmentData = $apiData['data'];

            $enrollment = EnrollmentFactory::fromArrayDetail([
                'id' => (int) $enrollmentData['id'],
                'schoolYear' => $enrollmentData['schoolYear'],
                'section' => $enrollmentData['section'],
                'grade' => (int) $enrollmentData['grade']
            ]);

            //throw new \ErrorException(json_encode($enrollment));
        }

        $project = new LearningProjectDetailDTO(
            id: $model->id,
            title: $model->title,
            content: $model->content,
            schoolMoment: $model->school_moment,
            teacher: null,
            enrollment: $enrollment,
        );



        $classes = $model->daily_classes;

        foreach ($classes as $class) {
            $project->addDailyClasses(DailyClassFactory::fromArray([
                'id' => $class->id,
                'date' => $class->date,
                'title' => $class->title,
                'content' => $class->content
            ]));
        }

        return $project;
    }

    protected function transformToSearchDTO(Model $model): DTOSearch
    {
        return new DTOSearch(
            id: $model->id,
            title: $model->title,
            teacher_id: $model->teacher_id,
            enrollment_id: $model->enrollment_id
        );
    }
}
