<?php

namespace App\Http\Controllers;

use App\Constants\TDTO;
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
        $data = $this->enrollmentServices->findAllEnrollment(TDTO::DETAIL);
        return Inertia::render('Enrollment/ListSections', [
            'sections' => array_map(function ($item) {
                return $item->toArray();
            }, $data)
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



    public function assignTeacher(Request $request)
    {
        $request->validate([
            'enrollmentId' => 'required|integer',
        ]);
        $enrollmentId = $request->input('enrollmentId');

        $data = $this->teacherServices->findAllNotEnrollmentPeriod($enrollmentId);
        return Inertia::render('Enrollment/AsignateTeacher', [
            'enrollmentId' => $enrollmentId,
            'teachers' => $data
        ]);
    }



    public function assignTeacherSave(Request $request)
    {
        $enrollmentId = $request->input('enrollmentId');
        $teacherId = $request->input('teacherId');

        if (!is_numeric($enrollmentId) || !is_numeric($teacherId)) {
            throw new \InvalidArgumentException('El enrollmentId y teacherId deben ser numéricos.');
        }
        return $this->enrollmentServices->assignTeacherToEnrollment($enrollmentId, $teacherId);
    }



    public function addStudent(Request $request)
    {
        $validated = $request->validate([
            'enrollmentId' => 'required|integer',
        ]);

        $id = $request->input('enrollmentId');

        return $this->enrollmentServices->addStudentPage($id);
    }


    public function addStudentSave(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'enrollmentId' => 'required|integer',
            'studentId' => 'required|integer',
        ]);

        if ($validate->fails()) {
            throw new ValidationException($validate->messages());
        }

        return $this->enrollmentServices->addStudentSave($request->input('enrollmentId'), $request->input('studentId'));
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


    public function findEnrollmentByYearSchool(string $moment)
    {
        return $this->enrollmentServices->findEnrollmentByYearSchool($moment);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * This method should return a view with a form to edit
     * the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('Enrollment/EditEnrollment');
        return response()->json($this->enrollmentServices->findEnrollment($id));
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
