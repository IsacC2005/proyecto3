<?php

namespace App\Jobs;

use App\Services\JapecoSyncService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class JapecoSyncJob implements ShouldQueue
{
    use Queueable;


    public $tries = 3;

    public $queu = 'japeco-sync';
    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(JapecoSyncService $syncService)
    {
        try {
            $syncService->JapecoSync();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
