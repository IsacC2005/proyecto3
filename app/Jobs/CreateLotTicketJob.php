<?php

namespace App\Jobs;

use App\Services\TicketServices;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;

class CreateLotTicketJob implements ShouldQueue
{
    use Queueable;

    protected $projectId;
    /**
     * Create a new job instance.
     */
    public function __construct(int $projectId)
    {
        $this->projectId = $projectId;
    }

    /**
     * Execute the job.
     */
    public function handle(TicketServices $service): void
    {

        $service->createLot($this->projectId);
    }
}
