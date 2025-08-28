<?php

namespace App\Http\Controllers;

use App\Exceptions\LearningProject\LearningProjectNotCreatedException;
use App\Factories\LearningProjectFactory;
use App\Services\LearningProjectServices;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LearningProjectController extends Controller
{

    public function __construct(
        private LearningProjectServices $learningProjectServices
    ) {}
    /**
     * Display a listing of the resource.
     *
     * This method should retrieve all resources from the database
     * and return a view displaying the list of resources.
     */
    public function index()
    {
        $data = $this->learningProjectServices->findByTeacher();
        return Inertia::render('LearningProject/ListLearningProjects', [
            'projects' => array_map(function ($aux) {
                return $aux->toArray();
            }, $data)
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
        $validated = $request->validate([
            'enrollmentId' => 'required|numeric',
            'teacherId' => 'required|numeric',
        ]);
        $enrollmentId = $validated['enrollmentId'];
        $teacherId = $validated['teacherId'];
        return $this->learningProjectServices->findByEnrollment($enrollmentId, $teacherId);
    }

    /**
     * Store a newly created resource in storage.
     *
     * This method should validate the request data and store
     * a new resource in the database.
     */
    public function store(Request $request)
    {
        $data =  LearningProjectFactory::fromRequestDetail($request);

        $this->learningProjectServices->createProject($data);
        return response()->json($data->getDailyClasses());
    }

    /**
     * Display the specified resource.
     *
     * This method should retrieve and display a single resource
     * identified by its ID.
     */
    public function show(string $id)
    {
        $data = $this->learningProjectServices->findById($id);
        return Inertia::render('LearningProject/ShowLearninProject', [
            'project' => $data->toArray()
        ]);
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
