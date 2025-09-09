<?php

namespace App\Services;

use App\Models\Teacher;
use App\Models\LearningProject;
use App\Models\DailyClass;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class DeshboardServices
{

    public function welcome()
    {
        // Se asume que el usuario autenticado es un profesor
        $teacher = Auth::user()->userable;

        // Se encuentra el proyecto de aprendizaje activo
        $activeLearningProject = $teacher->learning_projects()->first();

        // Si no hay un proyecto activo, devolvemos un array vacío
        if (!$activeLearningProject) {
            return [
                'learning_project' => null,
                'class_data' => [],
                'student_performance_summary' => [],
            ];
        }

        // 1. Datos para el gráfico de clases
        $classesData = $activeLearningProject->daily_classes()
            ->select('title', DB::raw('COUNT(id) as total_classes'))
            ->groupBy('title')
            ->get();

        // Contamos las clases evaluadas por proyecto
        // $evaluatedClassesCount = studentEvaluationItems::whereHas('evaluationItem.dailyClass', function ($query) use ($activeLearningProject) {
        //     $query->where('learning_project_id', $activeLearningProject->id);
        // })->count();

        $classGraphData = [
            'project_name' => $activeLearningProject->title,
            'total_classes' => $classesData->sum('total_classes'),
            'evaluated_classes' => 8,
            'class_details' => $classesData->map(function ($item) {
                return [
                    'title' => $item->title,
                    'count' => $item->total_classes,
                ];
            }),
        ];

        // 2. Datos para el resumen de rendimiento de estudiantes
        // $studentPerformanceSummary = Enrollment::whereHas('learningProject', function ($query) use ($activeLearningProject) {
        //     $query->where('learning_projects.id', $activeLearningProject->id);
        // })
        //     ->with('students.studentEvaluationItems')
        //     ->get()
        //     ->flatMap(function ($enrollment) {
        //         return $enrollment->students;
        //     })
        //     ->map(function ($student) {
        //         $averageRating = $student->studentEvaluationItems->avg('rate');
        //         $status = 'Bajo'; // Estado por defecto

        //         if ($averageRating >= 16) {
        //             $status = 'Excelente';
        //         } elseif ($averageRating >= 12) {
        //             $status = 'Bueno';
        //         } elseif ($averageRating >= 8) {
        //             $status = 'Regular';
        //         }

        //         return [
        //             'student_id' => $student->id,
        //             'student_name' => $student->name . ' ' . $student->surname,
        //             'average_rating' => round($averageRating ?? 0, 2),
        //             'performance_status' => $status,
        //         ];
        //     })
        //     ->groupBy('performance_status')
        //     ->map(function ($group) {
        //         return $group->count();
        //     });

        // Se crea el array final con todos los datos
        $welcomeData = [
            'learning_project' => [
                'id' => $activeLearningProject->id,
                'title' => $activeLearningProject->title,
            ],
            'class_data' => $classGraphData,
            'student_performance_summary' => [],
        ];

        return $welcomeData;
    }
}
