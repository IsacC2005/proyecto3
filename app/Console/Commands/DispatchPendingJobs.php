<?php

namespace App\Console\Commands;

use App\Jobs\CreateTicketJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class DispatchPendingJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ia:dispatch-pending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch pending IA jobs saved in cache.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $data = Cache::get('ia_pendientes_list', ['data' => []]);
        $pendingJobs = $data['data'];

        if (empty($pendingJobs)) {
            $this->info('No hay trabajos pendientes para despachar.');
            return;
        }

        $limit = 10;
        $jobsToDispatch = array_splice($pendingJobs, 0, $limit);

        $this->info("Despachando {$limit} trabajos de la lista de pendientes...");

        foreach ($jobsToDispatch as $jobData) {
            $projectId = $jobData['projectId'];
            $studentId = $jobData['studentId'];
            $totalStudents = $jobData['totalStudents'];
            $cacheKey = $jobData['cacheKey'];

            CreateTicketJob::dispatch(
                $projectId,
                $studentId,
                $totalStudents,
                $cacheKey,
            );
        }

        Cache::put('ia_pendientes_list', ['data' => $pendingJobs], now()->addDays(7));

        $this->info('Trabajos despachados exitosamente. Restantes: ' . count($pendingJobs));

        if (empty($pendingJobs)) {
            Cache::forget('ia_pendientes_list');
            $this->info('Lista de pendientes vacía y limpiada.');
        }

        return self::SUCCESS;
    }
}
