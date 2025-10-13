<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index()
    {
        // Recupera los logs, paginados (ej. 20 por página) y ordenados por fecha
        $logs = Activity::with('causer') // Incluye el usuario asociado (causer)
            ->latest() // Los más recientes primero
            ->paginate(20)
            ->through(function ($activity) {
                return [
                    'id' => $activity->id,
                    'description' => $activity->description,
                    'subject_type' => $activity->subject_type,
                    'subject_id' => $activity->subject_id,
                    'causer_name' => $activity->causer ? $activity->causer->name : 'Sistema', // Nombre del usuario
                    'created_at' => $activity->created_at->diffForHumans(), // Hace cuánto tiempo
                    'properties' => $activity->properties, // Datos adicionales (ej. los cambios)
                ];
            });

        // Retorna la vista Inertia con los logs
        return Inertia::render('ActivityLog/ActivityLog', [
            'logs' => $logs,
        ]);
    }
}
