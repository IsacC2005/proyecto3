<?php

namespace App\Http\Controllers;

use App\Services\TicketServices;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TicketController extends Controller
{

    public function __construct(
        private TicketServices $ticket
    ) {}
    /**
     * Display a listing of the resource.
     * 
     * This method should retrieve all resources from the database
     * and return a view displaying the list of resources.
     */
    public function index()
    {
        $data = $this->ticket->getAllTicketToProject(1);
        return Inertia::render('Ticket/ListTicket', [
            'tickets' => $data
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

        $data = $this->ticket->createShowPage();

        // return $data;
        return Inertia::render('Ticket/Create', [
            'project' => $data["project"],
            'students' => $data["students"]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * This method should validate the request data and store
     * a new resource in the database.
     */
    public function store(Request $request)
    {

        return $this->ticket->create(1, 1);
        // Debería guardar un nuevo elemento en la base de datos.
    }



    public function storeLot(int $id)
    {
        $this->ticket->createLot($id);
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
