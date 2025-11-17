<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttenceRequest;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{

    public function __construct(
        // public Attendance $attendance
    ) {}

    public function store(AttenceRequest $request)
    {

        $projectId = $request->input('projectId');
        $studentId = $request->input('studentId');

        Attendance::create([
            'learning_project_id' => $projectId,
            'student_id' => $studentId,
            'day' => now(),
            'attendance' => true
        ]);
    }
}
