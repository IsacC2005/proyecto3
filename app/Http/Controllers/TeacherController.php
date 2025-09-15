<?php

namespace App\Http\Controllers;

use App\Factories\TeacherFactory;
use App\Services\TeacherServices;
use App\Services\EvaluationServices;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TeacherController extends Controller
{
    public function __construct(
        private TeacherServices $teacherServices,
        private EvaluationServices $evaluationServices,
    ) {}
    /**
     * Display a listing of the resource.
     *
     * This method should retrieve all resources from the database
     * and return a view displaying the list of resources.
     */
    public function index()
    {
        $teachers = $this->teacherServices->findAll();

        // Renderizar el componente de Vue "Professors" y pasarle los datos
        return Inertia::render('Teacher/ListTeachers', [
            'teachers' => $teachers,
        ]);
        // Debería devolver una vista con todos los elementos.
    }

    /**
     * Show the form for creating a new resource.
     *
     * This method should return a view containing a form
     * to create a new resource.
     */
    public function create()
    {
        return Inertia::render('Teacher/CreateTeacher');
    }

    /**
     * Store a newly created resource in storage.
     *
     * This method should validate the request data and store
     * a new resource in the database.
     */
    public function store(Request $request)
    {
        $teacher = TeacherFactory::fromRequest($request);

        return $this->teacherServices->createTeacher($teacher);
    }

    /**
     * Display the specified resource.
     *
     * This method should retrieve and display a single resource
     * identified by its ID.
     */

    public function show(string $id)
    {
        // Debería mostrar un elemento específico según su ID.
    }

    /**
     * Show the form for editing the specified resource.
     *
     * This method should return a view with a form to edit
     * the specified resource.
     */

    public function listStudentsEvaluate(Request $request)
    {
        $request->validate([
            'classId' => 'required|integer'
        ]);
        $classId = $request->input('classId');
        return $this->evaluationServices->listStudentsByClass($classId);
    }


    public function evaluateStudent(Request $request)
    {

        $request->validate([
            'indicatorId' => 'required|integer',
            'studentId' => 'required|integer',
            'note' => 'required|string|min:1|max:2'
        ]);

        $evaluationId = $request->input('indicatorId');
        $studentId = $request->input('studentId');
        $note = $request->input('note');

        //return "El estudiante id = $student_id tiene una nota de $note en la evaluation $evaluation_id";
        $this->evaluationServices->evaluateStudent($evaluationId, $studentId, $note);
    }



    public function edit(Request $request)
    {
        $request->validate([
            'teacherId' => 'required|integer',
        ]);

        $id = $request->input('teacherId');

        $teacher = $this->teacherServices->findTeacher($id);
        return Inertia::render('Teacher/EditTeacher', [
            'teacher' => $teacher
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * This method should validate the request data and update
     * the specified resource in the database.
     */
    public function update(Request $request, string $id)
    {
        $data = TeacherFactory::fromRequest($request);
        $data->id = $id;
        return $this->teacherServices->updateTeacher($data);
    }


    public function enrollmentsAssigns()
    {
        $data = $this->teacherServices->enrollmentsAssigns();

        return Inertia::render('Teacher/ListEnrollmentAssigns', [
            'enrollments' => $data
        ]);
    }

    public function evaluate()
    {
        return $this->teacherServices->evaluateShowPage();
    }


    /**
     * Remove the specified resource from storage.
     *
     * This method should delete the specified resource from the database.
     */
    public function destroy(string $id)
    {
        // Debería eliminar un elemento específico de la base de datos.
    }
}
