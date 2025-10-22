<?php

namespace App\Http\Controllers;

use App\Jobs\JapecoSyncJob;
use App\Models\JapecoSync;
use App\Services\JapecoSyncService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class JapecoSyncController extends Controller
{
    public function testContection()
    {
        try {
            $japecoUrl = env('JAPECO_URL');

            $response = Http::get("$japecoUrl/api/test-conection");

            if (!$response->successful()) {
                throw new \ErrorException();
            }
            $data = $response->json();

            return response()->json($data);
        } catch (\Throwable $th) {


            if ($th->getCode() === 0) {
            }

            return response()->json([
                'data' => 'false',
                'status' => 'error',
                'message' => 'Error de conexion'
            ]);
        }
    }

    public function JapecoSync()
    {
        $time = JapecoSync::first();
        return Inertia::render('JapecoSync/JapecoSync', [
            'lastSyncedAt' => $time->updated_at
        ]);
    }

    public function JapecoSyncStart()
    {
        Cache::put('japeco-sync', [
            'percentage' => 0,
            'message' => 'Comensando sincronizacion...',
            'finished' => false
        ], now()->addHours(1));
        JapecoSyncJob::dispatch()->onQueue('japeco-sync');
    }


    public function JapecoSyncProgress()
    {
        $data = Cache::get('japeco-sync', [
            'percentage' => 0,
            'message' => 'Comensando sincronizacion...',
            'finished' => false
        ]);

        return response()->json($data);
    }
}
