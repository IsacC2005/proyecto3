<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\TicketServices;
use App\Exceptions\ia\DailyLimitExceededException;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;

class CreateTicketJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public function __construct(
        protected int $projectId,
        protected int $studentId,
        protected int $totalStudents,
        protected string $cacheKey,
    ) {}

    public function middleware(): array
    {
        return [
            //new RateLimited('gemini_jobs')
        ];
    }

    /**
     * Ejecuta el trabajo de creación de un único documento.
     */
    public function handle(TicketServices $service): void
    {
        $limitKey = config('ia_limits.rate_limit_key');
        $maxAttempts = config('ia_limits.rate_limit');
        $dailyLimit = config('ia_limits.daily_limit');

        if (RateLimiter::tooManyAttempts($limitKey, 10)) {

            $data = Cache::get('ia_pendientes_list', ['data' => []]);

            // 2. Extrae y añade los parámetros del Job actual.
            $data['data'][] = [
                'projectId' => $this->projectId,
                'studentId' => $this->studentId,
                'totalStudents' => $this->totalStudents,
                'cacheKey' => $this->cacheKey,
            ];

            Cache::put('ia_pendientes_list', $data, now()->addDays(7));

            $this->delete();

            return;
        }

        DB::transaction(
            function () use ($dailyLimit) {
                //     // Bloqueamos el único registro de uso diario.
                $usage = DB::table('ia_daily_usages')->lockForUpdate()->find(1);

                // Si es un nuevo día, reseteamos el contador
                if ($usage->last_reset_date !== now()->toDateString()) {
                    DB::table('ia_daily_usages')->where('id', 1)->update([
                        'request_count' => 0,
                        'last_reset_date' => now()->toDateString(),
                        'updated_at' => now(),
                    ]);
                    $usage->request_count = 0;
                }

                // Verificamos el límite diario. Si se excede, lanzamos la excepción
                if ($usage->request_count >= $dailyLimit) {
                    $midnight = now()->addDay()->startOfDay();
                    $retryAfter = now()->diffInSeconds($midnight) + 60;

                    //sleep($retryAfter);
                    DB::table('ia_daily_usages')->where('id', 1)->update([
                        'request_count' => 0,
                        'last_reset_date' => now()->toDateString(),
                        'updated_at' => now(),
                    ]);
                }

                // Si el límite NO se ha alcanzado, incrementamos el contador de forma segura
                DB::table('ia_daily_usages')->where('id', 1)->increment('request_count');
            }
        );

        RateLimiter::hit($limitKey);

        try {
            $service->create($this->projectId, $this->studentId);

            $this->updateProgress();
        } catch (DailyLimitExceededException $e) {

            $retryAfter = $e->getRetryAfter();
            Log::warning("Límite diario IA alcanzado. Pausando documento para reintento en {$retryAfter}s.");

            $this->release($retryAfter);
        } catch (\RuntimeException $e) {
            if ($e->getCode() === 429) {
                Log::warning("Límite por minuto IA alcanzado. Reintentando documento en 10s.");
                $this->release(10);
            } else {
                Log::error("Error al crear documento para estudiante {$this->studentId}: " . $e->getMessage());
                throw $e;
            }
        }
    }

    /**
     * Actualiza el progreso de caché para la barra de estado.
     */
    protected function updateProgress(): void
    {
        // Incrementa el contador de documentos completados.
        Cache::increment($this->cacheKey . '_completed');

        $completedCount = Cache::get($this->cacheKey . '_completed', 0);

        if ($completedCount <= $this->totalStudents) {
            $progressPercent = round(($completedCount / $this->totalStudents) * 100);

            $statusDescription = "$completedCount documentos de $this->totalStudents";

            Cache::put($this->cacheKey, [
                'percentage' => $progressPercent,
                'message' => $statusDescription,
                'finished' => ($completedCount == $this->totalStudents)
            ], now()->addHours(1));
        }
    }

    /**
     * En caso de que el job haya fallado (superado $this->tries)
     */
    public function failed(\Throwable $exception): void
    {
        // Opcional: registrar que un estudiante falló para no considerarlo completado.
        Log::error("Documento final fallido para estudiante {$this->studentId}: " . $exception->getMessage());
        // Se puede decrementar el contador aquí si es necesario.
    }
}
