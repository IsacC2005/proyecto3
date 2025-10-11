<?php

namespace App\Services;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class JapecoSyncService
{
    private $japecoUrl;

    public function __construct()
    {
        $this->japecoUrl = env('JAPECO_URL');
    }


    public function JapecoSysnc()
    {
        $this->TeacherSysnc();
        $this->StudentSync();
        return $this->EnrollmentSync();
    }



    // TODO: Esta funcion privada busca en el API de japeco todos los
    // TODO: y los registra en la base de datos local
    private function TeacherSysnc(): array
    {
        if (empty($this->japecoUrl)) {
            Log::error('JAPECO_URL no está configurada en el archivo .env.');
            return ['status' => 'error', 'message' => 'URL de API no configurada. ' . $this->japecoUrl];
        }

        // 1. Obtener datos de la API
        try {
            $japecoUrl = env('JAPECO_URL');
            $response = Http::get($japecoUrl . '/api/teacher/index');

            if ($response->failed() || !isset($response->json()['data'])) {
                $status = $response->status() ?? 'N/A';
                throw new \Exception("Fallo al obtener datos de Japeco. Código de estado: {$status}");
            }

            $apiTeachers = $response->json()['data'];
            $teachersToUpsert = [];

            // 2. Preparar los datos para el upsert
            foreach ($apiTeachers as $apiTeacher) {
                // Limpiamos los campos que a veces tienen espacios en blanco ('idcard')
                $idCard = trim($apiTeacher['idcard'] ?? '');
                $phone = $apiTeacher['phone'] ?? null;

                $teachersToUpsert[] = [
                    'japeco_id' => $apiTeacher['id'],
                    'name' => trim($apiTeacher['name'] ?? ''),
                    'surname' => trim($apiTeacher['surname'] ?? ''),
                    'idcard' => $idCard === 'NO' ? null : $idCard,
                    'phone' => $phone === 'NO' ? null : $phone,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            if (empty($teachersToUpsert)) {
                return ['status' => 'success', 'message' => 'No hay profesores para sincronizar.', 'count' => 0];
            }

            // 3. Realizar la sincronización (Upsert)
            // Usamos 'japeco_id' como la columna única.
            // Actualizamos 'name', 'surname', 'idcard_number', y 'phone' si el registro existe.
            $upsertCount = Teacher::upsert(
                $teachersToUpsert,
                ['japeco_id'], // Clave única para determinar si existe
                ['name', 'surname', 'idcard', 'phone', 'updated_at']
            );

            // 4. Eliminar registros locales que ya no están en la API (Opcional pero recomendado para sincronización completa)
            // Primero obtenemos todos los japeco_id que deben existir
            $currentJapecoIds = collect($teachersToUpsert)->pluck('japeco_id')->all();

            // Eliminamos los registros locales donde el japeco_id NO esté en el array
            $deletedCount = Teacher::whereNotNull('japeco_id')
                ->whereNotIn('japeco_id', $currentJapecoIds)
                ->delete();


            return [
                'status' => 'success',
                'message' => 'Sincronización de profesores completada.',
                'upserted' => $upsertCount,
                'deleted' => $deletedCount,
            ];
        } catch (\Exception $e) {
            Log::error('Error de sincronización con Japeco: ' . $e->getMessage());
            return ['status' => 'error', 'message' => 'Error de sincronización: ' . $e->getMessage()];
        }
    }


    // TODO: 
    private function StudentSync(): array
    {
        if (empty($this->japecoUrl)) {
            Log::error('JAPECO_URL no está configurada en el archivo .env.');
            return ['status' => 'error', 'message' => 'URL de API no configurada.'];
        }

        try {
            $response = Http::get($this->japecoUrl . '/api/student/index');

            if ($response->failed() || !isset($response->json()['data'])) {
                $status = $response->status() ?? 'N/A';
                throw new \Exception("Fallo al obtener datos de estudiantes de Japeco. Código de estado: {$status}");
            }

            $apiStudents = $response->json()['data'];
            $studentsToUpsert = [];

            // 2. Preparar los datos
            foreach ($apiStudents as $apiStudent) {

                $studentsToUpsert[] = [
                    'japeco_id' => $apiStudent['id'],             // Clave única del estudiante en la API
                    'school_id' => $apiStudent['schoolId'] ?? null, // ID de escuela de la API
                    'grade' => 0,
                    'name' => trim($apiStudent['name'] ?? ''),
                    'surname' => trim($apiStudent['surname'] ?? ''),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            if (empty($studentsToUpsert)) {
                return ['status' => 'success', 'message' => 'No hay estudiantes para sincronizar.', 'upserted' => 0, 'deleted' => 0];
            }

            // 3. Realizar la sincronización (Upsert) con procesamiento por lotes (Batching)
            $totalUpserted = 0;
            $batchSize = 1000;

            $currentJapecoIds = collect($studentsToUpsert)->pluck('japeco_id');

            $currentJapecoIds
                ->chunk($batchSize)
                ->each(function ($chunk) use (&$totalUpserted, $studentsToUpsert) {
                    // Filtramos solo los datos del lote actual
                    $chunkData = collect($studentsToUpsert)->whereIn('japeco_id', $chunk)->toArray();

                    $totalUpserted += Student::upsert(
                        $chunkData,
                        ['japeco_id'], // Clave única para determinar si existe
                        ['school_id', 'name', 'surname', 'updated_at'] // Columnas a actualizar
                    );
                });

            // 4. Eliminar registros locales que ya no están en la API 
            $deletedCount = Student::whereNotNull('japeco_id')
                ->whereNotIn('japeco_id', $currentJapecoIds->all())
                ->delete();


            return [
                'status' => 'success',
                'message' => 'Sincronización de estudiantes completada.',
                'upserted' => $totalUpserted,
                'deleted' => $deletedCount,
            ];
        } catch (\Exception $e) {
            Log::error('Error de sincronización con Japeco (Estudiantes): ' . $e->getMessage());
            return ['status' => 'error', 'message' => 'Error de sincronización de estudiantes: ' . $e->getMessage()];
        }
    }


    /**
     * Sincroniza las inscripciones (Enrollments) desde la API Japeco, resolviendo la relación 'teacher_id'.
     *
     * @return array Resultados de la sincronización (conteo de registros)
     */
    private function EnrollmentSync(): array
    {
        if (empty($this->japecoUrl)) {
            Log::error('JAPECO_URL no está configurada en el archivo .env.');
            return ['status' => 'error', 'message' => 'URL de API no configurada.'];
        }

        try {
            // Se actualiza la URL según el nuevo endpoint
            $response = Http::get($this->japecoUrl . '/api/section/details');

            if ($response->failed() || !isset($response->json()['data'])) {
                $status = $response->status() ?? 'N/A';
                throw new \Exception("Fallo al obtener datos de secciones de Japeco. Código de estado: {$status}");
            }

            $apiEnrollments = $response->json()['data'];
            $enrollmentsToUpsert = [];

            // 1.5. CREAR MAPA DE BÚSQUEDA DE PROFESORES: Necesario para resolver teacher_id.
            // Ahora usamos 'idcard_number' como clave para la búsqueda.
            $localTeachers = Teacher::select('id', 'idcard')->get();
            // Creamos un lookup eficiente: ['ID_CARD_NUMBER' => LOCAL_ID]
            $teacherLookup = $localTeachers->pluck('id', 'idcard')->all();



            // 2.2. Mapa de Estudiantes (por japeco_id)
            // Necesario para la sincronización N:M
            $localStudents = Student::select('id', 'japeco_id')->get();
            $studentLookup = $localStudents->pluck('id', 'japeco_id')->all();

            // 2. Preparar los datos
            foreach ($apiEnrollments as $apiEnrollment) {
                // El profesor viene en un array anidado. Tomamos el primer elemento.
                $teacherData = $apiEnrollment['teacher'][0] ?? null;
                $apiIdCard = null;
                $localTeacherId = null;

                if ($teacherData) {
                    $apiIdCard = trim($teacherData['idcard'] ?? '');
                    // Buscamos el ID local usando el número de cédula (idcard)
                    $localTeacherId = $teacherLookup[$apiIdCard] ?? null;
                }

                if ($localTeacherId === null && $apiIdCard !== null && !empty($apiIdCard)) {
                    // Si el profesor no se encuentra, registramos una advertencia
                    Log::warning("Profesor no encontrado para la inscripción ID: {$apiEnrollment['id']} (Cédula API: {$apiIdCard}). Asegúrese de que el profesor esté sincronizado primero.");
                }

                // El campo 'school-year' tiene un guión en el nuevo JSON
                $schoolYear = trim($apiEnrollment['school-year'] ?? '');

                $enrollmentsToUpsert[] = [
                    'japeco_id' => $apiEnrollment['id'],             // Clave única de la API
                    'teacher_id' => $localTeacherId,                 // Clave foránea local resuelta
                    'school_year' => $schoolYear,
                    'grade' => $apiEnrollment['grade'] ?? null,
                    'section' => trim($apiEnrollment['section'] ?? ''),
                    'classroom' => trim($apiEnrollment['classroom'] ?? ''),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // NOTA: La sincronización de la relación Enrollment -> Student (muchos a muchos)
                // NO se puede hacer con un solo upsert de Enrollment. Se requeriría un paso adicional 
                // con attach/sync en esta misma función si deseas sincronizar también a los estudiantes 
                // de cada sección. Por ahora, solo sincronizamos los datos de la sección/inscripción.

            }

            if (empty($enrollmentsToUpsert)) {
                return ['status' => 'success', 'message' => 'No hay inscripciones para sincronizar.', 'upserted' => 0, 'deleted' => 0];
            }

            $totalUpserted = 0;
            $batchSize = 1000;

            $currentJapecoIds = collect($enrollmentsToUpsert)->pluck('japeco_id');

            $currentJapecoIds
                ->chunk($batchSize)
                ->each(function ($chunk) use (&$totalUpserted, $enrollmentsToUpsert) {
                    // Filtramos solo los datos del lote actual
                    $chunkData = collect($enrollmentsToUpsert)->whereIn('japeco_id', $chunk)->toArray();

                    $totalUpserted += Enrollment::upsert(
                        $chunkData,
                        ['japeco_id'], // Clave única para determinar si existe
                        ['teacher_id', 'school_year', 'grade', 'section', 'classroom', 'updated_at'] // Columnas a actualizar
                    );
                });

            // 4. Eliminar registros locales que ya no están en la API 
            $deletedCount = Enrollment::whereNotNull('japeco_id')
                ->whereNotIn('japeco_id', $currentJapecoIds->all())
                ->delete();
            $localEnrollments = Enrollment::whereIn('japeco_id', $currentJapecoIds->all())
                ->get()
                ->keyBy('japeco_id'); // Indexar por japeco_id para búsqueda rápida

            $totalPivotSync = 0;

            // 5.2 Iterar sobre los datos originales de la API
            foreach ($apiEnrollments as $apiEnrollment) {
                $japecoId = $apiEnrollment['id'];
                $localEnrollment = $localEnrollments->get($japecoId);

                if (!$localEnrollment) {
                    // Esto no debería suceder si el upsert fue exitoso
                    continue;
                }

                $apiStudents = $apiEnrollment['students'] ?? [];
                $studentIdsToSync = [];

                // Resolver los IDs de estudiantes locales
                foreach ($apiStudents as $apiStudent) {
                    $apiStudentJapecoId = $apiStudent['id'] ?? null;
                    if ($apiStudentJapecoId && isset($studentLookup[$apiStudentJapecoId])) {
                        // Agregamos el ID local del estudiante
                        $studentIdsToSync[] = $studentLookup[$apiStudentJapecoId];
                    } else if ($apiStudentJapecoId) {
                        // Advertencia si un estudiante de la sección no se encontró localmente
                        Log::warning("Estudiante con japeco_id {$apiStudentJapecoId} no se encontró localmente para la inscripción {$localEnrollment->id}.");
                    }
                }

                // Usar sync() para actualizar la tabla pivote (attach/detach automáticamente)
                if (!empty($studentIdsToSync)) {
                    $localEnrollment->students()->sync($studentIdsToSync);
                    $totalPivotSync++;
                } else {
                    // Si la API no trae estudiantes, aseguramos que la sección quede vacía
                    $localEnrollment->students()->sync([]);
                }
            }

            return [
                'status' => 'success',
                'message' => 'Sincronización de inscripciones completada.',
                'upserted' => $totalUpserted,
                'deleted' => $deletedCount,
                'pivot_sync' => $totalPivotSync, // Conteo de enrollments cuya tabla pivote fue sincronizada
            ];


            return [
                'status' => 'success',
                'message' => 'Sincronización de inscripciones completada.',
                'upserted' => $totalUpserted,
                'deleted' => $deletedCount,
            ];
        } catch (\Exception $e) {
            Log::error('Error de sincronización con Japeco (Inscripciones): ' . $e->getMessage());
            return ['status' => 'error', 'message' => 'Error de sincronización de inscripciones: ' . $e->getMessage()];
        }
    }
}
