<?php

namespace App\Http\Controllers;

use App\Constants\TDTO;
use App\Exceptions\LearningProject\LearningProjectNotCreatedException;
use App\Factories\LearningProjectFactory;
use App\Services\LearningProjectServices;
use App\Services\ResultNoteServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

use function PHPUnit\Framework\isNumeric;

class LearningProjectController extends Controller
{

    public function __construct(
        private LearningProjectServices $learningProjectServices,
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


    public function createClass()
    {
        return $this->learningProjectServices->findActived();
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

        return $this->learningProjectServices->createProject($data);
        ///return response()->json($data->getDailyClasses());
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
        if (is_numeric($id)) {
            $data = $this->learningProjectServices->findById($id);
            return Inertia::render('LearningProject/EditLearningProject', ['project' => $data->toArray()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * This method should validate the request data and update
     * the specified resource in the database.
     */
    public function update(Request $request, string $id)
    {
        if (!isNumeric($id)) {
            return;
        }
        $data = LearningProjectFactory::fromRequest($request);
        $data->id = $id;

        $this->learningProjectServices->updateProject($data);

        $request->session()->flash('flash', [
            'modal' => [
                'title' => '¡Éxito!',
                'message' => 'El proyecto de aprendizaje se actualizó con éxito.'
            ]
        ]);

        // Redirecciona a una URL con método GET, por ejemplo, el dashboard
        return Redirect::route('dashboard')->with(
            'flash',
            [
                'modal' => [
                    'title' => '¡Exito!',
                    'message' => 'El proyecto de aprendizaje se actualizo :)).',
                ]
            ]
        );

        //return response()->json($data);
        // Debería actualizar un elemento existente en la base de datos.
    }


    public function notes(?string $id = null)
    {
        $data = $this->learningProjectServices->Notes($id);
        //return response()->json($data);
        return Inertia::render('Notes/ListNotes', [
            'data' => $data
        ]);
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
