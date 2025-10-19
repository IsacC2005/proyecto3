<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LearningProjectQualiteStudent;
use App\Models\LearningProjectQualitieStudentStatus;
use App\Services\QualitieServices;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;



class QualitieController extends Controller
{

    public function __construct(
        private QualitieServices $qualitieServices
    ) {}
    /**
     * Inserta una nueva evaluación en la tabla pivote.
     */

    public function create()
    {
        //return response()->json();
        return $this->qualitieServices->evaluate();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|integer',
            'learning_project_id' => 'required|integer',
            'qualitie_id' => 'nullable|integer',
            'qualitie' => 'nullable|string'
        ]);
        DB::transaction(function () use ($validated) {
            $exist = LearningProjectQualiteStudent::where('student_id', $validated['student_id'])
                ->where('learning_project_id', $validated['learning_project_id'])
                ->where('qualitie_id', $validated['qualitie_id'])
                ->first();

            if ($exist) {
                $exist->delete();
            } else {
                LearningProjectQualiteStudent::create($validated);
            }
        });
    }

    public function storeStatus(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|integer',
            'learning_project_id' => 'required|integer'
        ]);


        $statusRecord = LearningProjectQualitieStudentStatus::where('student_id', $request->input('student_id'))
            ->where('learning_project_id', $request->input('learning_project_id'))->first();

        if ($statusRecord) {

            $newStatus = !$statusRecord->status;

            $statusRecord->update(['status' => $newStatus]);
        } else {
            LearningProjectQualitieStudentStatus::create([
                'student_id' => $request->input('student_id'),
                'learning_project_id' => $request->input('learning_project_id'),
                'status' => true
            ]);
        }
    }
}
