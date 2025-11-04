<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Inertia\Inertia;

class BackupController extends Controller
{
    // Muestra la lista de respaldos
    public function index()
    {

        $output = '';

        $phpBinary = 'php';

        $command = "{$phpBinary} " . base_path('artisan') . " backup:list";

        $output = shell_exec($command);

        return Inertia::render('Backups/Index', [
            'backupListOutput' => $output,
        ]);
    }

    // Ejecuta un nuevo respaldo
    public function store()
    {
        try {
            $phpBinary = 'php';

            $command = "{$phpBinary} " . base_path('artisan') . " backup:run";

            shell_exec($command);

            return redirect()->back()
                ->with('success', '¡Respaldo de base de datos iniciado correctamente!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al ejecutar el respaldo: ' . $e->getMessage());
        }
    }

    // Ejecuta la limpieza de respaldos antiguos
    public function destroy()
    {
        try {

            $phpBinary = 'php';

            $command = "{$phpBinary} " . base_path('artisan') . " backup:clean";
            shell_exec($command);

            return redirect()->back()
                ->with('success', '¡Limpieza de respaldos antiguos ejecutada correctamente!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al ejecutar la limpieza: ' . $e->getMessage());
        }
    }
}
