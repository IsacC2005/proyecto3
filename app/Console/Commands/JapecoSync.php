<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\JapecoSyncJob;

class JapecoSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:japeco-sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Syncronizando Datos con Japeco';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        JapecoSyncJob::dispatch()->onQueue('japeco-sync');
    }
}
