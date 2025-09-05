<?php

namespace App\Http\Controllers;

use App\Factories\DailyClassFactory;
use App\Factories\LearningProjectFactory;
use App\Services\DailyClassServices;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DailyClassController extends Controller
{

    public function __construct(
        private DailyClassServices $dailyClassServices
    ) {}
    /**
     * Display a listing of the resource.
     *
     * This method should retrieve all resources from the database
     * and return a view displaying the list of resources.
     */
    public function index()
    {
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
        return $this->dailyClassServices->createDailyClassShowPage();
        // Debería mostrar el formulario para crear un nuevo elemento.
    }

    /**
     * Store a newly created resource in storage.
     *
     * This method should validate the request data and store
     * a new resource in the database.
     */
    public function store(Request $request)
    {
        $data =  DailyClassFactory::fromRequestDetail($request);
        $data->learningProject = LearningProjectFactory::fromArrayDetail(['id' => $request->input('projectId')]);
        $this->dailyClassServices->createDailyClass($data);

        return response()->json($data->toArray());
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
        $data = $this->dailyClassServices->findById($id);
        return Inertia::render(
            'DailyClass/EditDailyClass',
            [
                'dailyClass' => $data->toArray()
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * This method should validate the request data and update
     * the specified resource in the database.
     */
    public function update(Request $request, string $id)
    {

        $data = DailyClassFactory::fromRequestDetail($request);

        //return response()->json($data->toArray());
        $this->dailyClassServices->updateClass($id, $data);
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
