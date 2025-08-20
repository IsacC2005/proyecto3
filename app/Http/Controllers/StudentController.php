<?php

namespace App\Http\Controllers;

use App\DTOs\Summary\DTOSummary;
use App\DTOs\Summary\StudentDTO;
use App\Factories\StudentFactory;
use App\Services\RepresentativeServices;
use App\Services\StudentServices;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentController extends Controller
{
    public function __construct(
        private StudentServices $studentServices,
        private RepresentativeServices $representativeServices
    ) {}
    /**
     * Display a listing of the resource.
     *
     * This method should retrieve all resources from the database
     * and return a view displaying the list of resources.
     */
    public function index()
    {
        $students = $this->studentServices->findAllStudent();
        return Inertia::render('Student/ListStudent', [
            'students' => $students
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * This method should return a view containing a form
     * to create a new resource.
     */
    public function create(Request $request)
    {
        $idcard = $request->input('idcard');
        return $this->studentServices->pageCreateShow($idcard);
    }

    /**
     * Store a newly created resource in storage.
     *
     * This method should validate the request data and store
     * a new resource in the database.
     */
    public function store(Request $request)
    {
        $data = StudentFactory::fromRequest($request);
        $this->studentServices->createStudent($data);
        return 'Estudiante creado crack';
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
