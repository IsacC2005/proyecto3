<?php

namespace App\Services;

use App\Constants\TDTO;
use App\Models\Teacher;
use App\Models\LearningProject;
use App\Models\DailyClass;
use App\Models\Enrollment;
use App\Models\EvaluationItem;
use App\Repositories\Interfaces\LearningProjectInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;




class DeshboardServices
{

    public function __construct(
        private DatesActual $date,
        private LearningProjectInterface $project
    ) {}

    public function welcome()
    {
        $teacher = Auth::user()->userable;

        $teacher_id = $teacher->id;

        $moment = $this->date->getSchoolMomentActual();
        $year = $this->date->getSchoolYearActual();


        $activeLearningProject = $this->project->findOnDate($year, $moment, $teacher_id, TDTO::DETAIL);

        if (!$activeLearningProject) {
            return [
                'project' => null,
            ];
        }

        $classes = DailyClass::with('evaluation_items')->where('learning_project_id', $activeLearningProject->id)->get();

        $classEvaluates = 0;

        // foreach ($activeLearningProject->getDailyClasses() as $class){

        // $classEvaluates = EvaluationItem::where('daily_class_id',$class->id )
        // }

        // 1. Datos para el gráfico de clases
        // $classesData = $activeLearningProject->daily_classes()
        //     ->select('title', DB::raw('COUNT(id) as total_classes'))
        //     ->groupBy('title')
        //     ->get();

        // Contamos las clases evaluadas por proyecto
        // $evaluatedClassesCount = studentEvaluationItems::whereHas('evaluationItem.dailyClass', function ($query) use ($activeLearningProject) {
        //     $query->where('learning_project_id', $activeLearningProject->id);
        // })->count();

        // $classGraphData = [
        //     'project_name' => $activeLearningProject->title,
        //     'total_classes' => $classesData->sum('total_classes'),
        //     'evaluated_classes' => 8,
        //     'class_details' => $classesData->map(function ($item) {
        //         return [
        //             'title' => $item->title,
        //             'count' => $item->total_classes,
        //         ];
        //     }),
        // ];

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
            'project' => $activeLearningProject->toArray(),
            'evaluateClasses' => $classEvaluates
        ];

        return $welcomeData;
    }
}
