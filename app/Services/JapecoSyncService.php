<?php

namespace App\Services;

use App\Models\Enrollment;
use App\Models\JapecoSync;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class JapecoSyncService
{
    private $japecoUrl;

    public function __construct()
    {
        $this->japecoUrl = env('JAPECO_URL');
    }


    public function JapecoSync()
    {
        Cache::put('japeco-sync', [
            'percentage' => 0,
            'message' => 'Comensando sincronizacion...',
            'finished' => false
        ], now()->addHours(1));

        $startTime = Carbon::now();

        $this->TeacherSysnc();
        $this->StudentSync();
        $this->EnrollmentSync();

        $finishTime = Carbon::now();
        $durationInSeconds = $startTime->diffInSeconds($finishTime);

        $time = JapecoSync::firstOrNew([]);

        $time->time_sync = $durationInSeconds;

        $time->save();


        Cache::put('japeco-sync', [
            'percentage' => 100,
            'message' => 'Sincronizacion completada...',
            'finished' => true
        ]);
    }



    // TODO: Esta funcion privada busca en el API de japeco todos los
    // TODO: y los registra en la base de datos local
    private function TeacherSysnc(): array
    {
        Cache::put('japeco-sync', [
            'percentage' => 0,
            'message' => 'Sincronizando profesores...',
            'finished' => false
        ]);
        if (empty($this->japecoUrl)) {
            Log::error('JAPECO_URL no está configurada en el archivo .env.');
            return ['status' => 'error', 'message' => 'URL de API no configurada. ' . $this->japecoUrl];
        }

        try {
            $japecoUrl = env('JAPECO_URL');
            $response = Http::get($japecoUrl . '/api/teacher/index');

            if ($response->failed() || !isset($response->json()['data'])) {
                $status = $response->status() ?? 'N/A';
                throw new \Exception("Fallo al obtener datos de Japeco. Código de estado: {$status}");
            }

            $apiTeachers = $response->json()['data'];
            $teachersToUpsert = [];

            $totalTeachers = count($apiTeachers);

            $i = 0;
            foreach ($apiTeachers as $apiTeacher) {
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
                $i++;
                Cache::put('japeco-sync', [
                    'percentage' => round(($i / $totalTeachers) * 100, 2),
                    'message' => 'Sincronizando profesores...',
                    'finished' => false
                ]);
            }

            if (empty($teachersToUpsert)) {
                return ['status' => 'success', 'message' => 'No hay profesores para sincronizar.', 'count' => 0];
            }

            $upsertCount = Teacher::upsert(
                $teachersToUpsert,
                ['japeco_id'],
                ['name', 'surname', 'idcard', 'phone', 'updated_at']
            );

            $currentJapecoIds = collect($teachersToUpsert)->pluck('japeco_id')->all();

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
        Cache::put('japeco-sync', [
            'percentage' => 0,
            'message' => 'Sincronizando estudiantes...',
            'finished' => false
        ]);
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

            $totalStudents = count($apiStudents);

            $i = 0;
            foreach ($apiStudents as $apiStudent) {

                $studentsToUpsert[] = [
                    'japeco_id' => $apiStudent['id'],
                    'school_id' => $apiStudent['schoolId'] ?? null,
                    'grade' => 0,
                    'name' => trim($apiStudent['name'] ?? ''),
                    'surname' => trim($apiStudent['surname'] ?? ''),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $i++;
                Cache::put('japeco-sync', [
                    'percentage' => round(($i / $totalStudents) * 100, 2),
                    'message' => 'Sincronizando estudiantes...',
                    'finished' => false
                ]);
            }

            if (empty($studentsToUpsert)) {
                return ['status' => 'success', 'message' => 'No hay estudiantes para sincronizar.', 'upserted' => 0, 'deleted' => 0];
            }

            $totalUpserted = 0;
            $batchSize = 1000;

            $currentJapecoIds = collect($studentsToUpsert)->pluck('japeco_id');

            $currentJapecoIds
                ->chunk($batchSize)
                ->each(function ($chunk) use (&$totalUpserted, $studentsToUpsert) {
                    $chunkData = collect($studentsToUpsert)->whereIn('japeco_id', $chunk)->toArray();

                    $totalUpserted += Student::upsert(
                        $chunkData,
                        ['japeco_id'],
                        ['school_id', 'name', 'surname', 'updated_at']
                    );
                });

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
        Cache::put('japeco-sync', [
            'percentage' => 0,
            'message' => 'Sincronizando matriculas...',
            'finished' => false
        ]);
        if (empty($this->japecoUrl)) {
            Log::error('JAPECO_URL no está configurada en el archivo .env.');
            return ['status' => 'error', 'message' => 'URL de API no configurada.'];
        }

        try {
            $response = Http::get($this->japecoUrl . '/api/section/details');

            if ($response->failed() || !isset($response->json()['data'])) {
                $status = $response->status() ?? 'N/A';
                throw new \Exception("Fallo al obtener datos de secciones de Japeco. Código de estado: {$status}");
            }

            $apiEnrollments = $response->json()['data'];
            $enrollmentsToUpsert = [];

            $totalEnrollments = count($apiEnrollments);

            $localTeachers = Teacher::select('id', 'idcard')->get();
            //
            $teacherLookup = $localTeachers->pluck('id', 'idcard')->all();


            //
            $localStudents = Student::select('id', 'japeco_id')->get();
            $studentLookup = $localStudents->pluck('id', 'japeco_id')->all();

            $i = 0;
            foreach ($apiEnrollments as $apiEnrollment) {
                $teacherData = $apiEnrollment['teacher'][0] ?? null;
                $apiIdCard = null;
                $localTeacherId = null;

                if ($teacherData) {
                    $apiIdCard = trim($teacherData['idcard'] ?? '');
                    $localTeacherId = $teacherLookup[$apiIdCard] ?? null;
                }

                if ($localTeacherId === null && $apiIdCard !== null && !empty($apiIdCard)) {
                    Log::warning("Profesor no encontrado para la inscripción ID: {$apiEnrollment['id']} (Cédula API: {$apiIdCard}). Asegúrese de que el profesor esté sincronizado primero.");
                }

                $schoolYear = trim($apiEnrollment['school-year'] ?? '');

                $enrollmentsToUpsert[] = [
                    'japeco_id' => $apiEnrollment['id'],
                    'teacher_id' => $localTeacherId,
                    'school_year' => $schoolYear,
                    'grade' => $apiEnrollment['grade'] ?? null,
                    'section' => trim($apiEnrollment['section'] ?? ''),
                    'classroom' => trim($apiEnrollment['classroom'] ?? ''),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $i++;
                Cache::put('japeco-sync', [
                    'percentage' => round(($i / $totalEnrollments) * 100, 2),
                    'message' => 'Sincronizando profesores...',
                    'finished' => false
                ]);
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
                    $chunkData = collect($enrollmentsToUpsert)->whereIn('japeco_id', $chunk)->toArray();

                    $totalUpserted += Enrollment::upsert(
                        $chunkData,
                        ['japeco_id'],
                        ['teacher_id', 'school_year', 'grade', 'section', 'classroom', 'updated_at'] // Columnas a actualizar
                    );
                });

            $deletedCount = Enrollment::whereNotNull('japeco_id')
                ->whereNotIn('japeco_id', $currentJapecoIds->all())
                ->delete();
            $localEnrollments = Enrollment::whereIn('japeco_id', $currentJapecoIds->all())
                ->get()
                ->keyBy('japeco_id');

            $totalPivotSync = 0;

            foreach ($apiEnrollments as $apiEnrollment) {
                $japecoId = $apiEnrollment['id'];
                $localEnrollment = $localEnrollments->get($japecoId);

                if (!$localEnrollment) {
                    continue;
                }

                $apiStudents = $apiEnrollment['students'] ?? [];
                $studentIdsToSync = [];

                foreach ($apiStudents as $apiStudent) {
                    $apiStudentJapecoId = $apiStudent['id'] ?? null;
                    if ($apiStudentJapecoId && isset($studentLookup[$apiStudentJapecoId])) {
                        $studentIdsToSync[] = $studentLookup[$apiStudentJapecoId];
                    } else if ($apiStudentJapecoId) {
                        Log::warning("Estudiante con japeco_id {$apiStudentJapecoId} no se encontró localmente para la inscripción {$localEnrollment->id}.");
                    }
                }

                if (!empty($studentIdsToSync)) {
                    $localEnrollment->students()->sync($studentIdsToSync);
                    $totalPivotSync++;
                } else {
                    $localEnrollment->students()->sync([]);
                }
            }

            return [
                'status' => 'success',
                'message' => 'Sincronización de inscripciones completada.',
                'upserted' => $totalUpserted,
                'deleted' => $deletedCount,
                'pivot_sync' => $totalPivotSync,
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
