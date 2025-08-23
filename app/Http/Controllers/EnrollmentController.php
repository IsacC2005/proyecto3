<?php

namespace App\Http\Controllers;

use App\Factories\EnrollmentFactory;
use App\Services\EnrollmentServices;
use App\Services\TeacherServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class EnrollmentController extends Controller
{

    public function __construct(
        private EnrollmentServices $enrollmentServices,
        private TeacherServices $teacherServices
    ) {}
    /**
     * Display a listing of the resource.
     *
     * This method should retrieve all resources from the database
     * and return a view displaying the list of resources.
     */
    public function index()
    {
        $data = $this->enrollmentServices->findAllEnrollment('transformToDetailDTO');
        return Inertia::render('Enrollment/ListEnrollment', [
            'sections' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * This method should return a view containing a form
     * to create a new resource.
     */
    public function create()
    {
        return Inertia::render('Enrollment/CreateEnrollment');
    }

    /**
     * Store a newly created resource in storage.
     *
     * This method should validate the request data and store
     * a new resource in the database.
     */
    public function store(Request $request)
    {
        $data = EnrollmentFactory::fromRequest($request);
        return $this->enrollmentServices->createEnrollment($data);
    }



    public function assignTeacher(int $id)
    {
        $data = $this->teacherServices->findAll();
        return Inertia::render('Enrollment/AsignateTeacher', [
            'id_enrollment' => $id,
            'teachers' => $data
        ]);
    }



    public function assignTeacherSave(Request $request)
    {
        $id_enrollment = $request->input('id_enrollment');
        $id_teacher = $request->input('id_teacher');

        if (!is_numeric($id_enrollment) || !is_numeric($id_teacher)) {
            throw new \InvalidArgumentException('El id_enrollment y id_teacher deben ser numéricos.');
        }
        return $this->enrollmentServices->assignTeacherToEnrollment($id_enrollment, $id_teacher);
    }



    public function addStudent(Request $request)
    {
        $validated = $request->validate([
            'enrollment_id' => 'required|integer',
        ]);

        return $this->enrollmentServices->addStudentPage($request->input('enrollment_id'));
    }


    public function addStudentSave(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'enrollment_id' => 'required|integer',
            'student_id' => 'required|integer',
        ]);

        if ($validate->fails()) {
            throw new ValidationException($validate->messages());
        }

        return $this->enrollmentServices->addStudentSave($request->input('enrollment_id'), $request->input('student_id'));
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
    public function edit(string $id)
    {
        // Debería mostrar el formulario para editar un elemento existente.
    }

    /**
     * Update the specified resource in storage.
     *
     * This method should validate the request data and update
     * the specified resource in the database.
     */
    public function update(Request $request, string $id)
    {
        // Debería actualizar un elemento existente en la base de datos.
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
