<?php

namespace App\Http\Controllers;

use App\Jobs\CreateLotTicketJob;
use App\Models\Ticket;
use App\Services\TicketServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class TicketController extends Controller
{

    public function __construct(
        private TicketServices $ticket,
    ) {}
    /**
     * Display a listing of the resource.
     * 
     * This method should retrieve all resources from the database
     * and return a view displaying the list of resources.
     */
    public function index(?string $id = null)
    {
        $projectId = (int) $id ?? null;
        return $this->ticket->getAllTicketToProject($projectId);
    }

    /**
     * Show the form for creating a new resource.
     * 
     * This method should return a view containing a form
     * to create a new resource.
     */
    public function create(?int $id = null)
    {
        return $this->ticket->createShowPage($id);

        // return $data;

    }

    /**
     * Store a newly created resource in storage.
     * 
     * This method should validate the request data and store
     * a new resource in the database.
     */
    public function store(Request $request)
    {
        $projectId = $request->input('projectId');
        $studentId = $request->input('studentId');

        return $this->ticket->create($projectId, $studentId);
        // Debería guardar un nuevo elemento en la base de datos.
    }



    public function storeLot(int $id)
    {

        $cacheKey = 'document_progress_' . $id;

        Cache::forget($cacheKey);

        Cache::put($cacheKey, [
            'percentage' => 0,
            'message' => 'Preparando la tarea de creación masiva...',
            'finished' => false
        ], now()->addHours(1));

        //CreateLotTicketJob::dispatch($id);
        $this->ticket->createLot($id);
        return response([], 202);
    }

    public function progressStoreLot(int $jobId)
    {
        $cacheKey = 'document_progress_' . $jobId;

        $status = Cache::get($cacheKey, [
            'percentage' => 0,
            'message' => 'Proceso no encontrado o en cola.',
            'finished' => true,
        ]);

        // Devuelve una respuesta JSON simple
        return response()->json($status);
    }

    /**
     * Display the specified resource.
     * 
     * This method should retrieve and display a single resource
     * identified by its ID.
     */
    public function show(string $id, Request $request)
    {

        return $this->ticket->show((int) $id, (int) $request->input('studentId'));
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
        $this->ticket->update();
    }

    public function impress(int $id)
    {
        return $this->ticket->impressTicket($id);
    }


    public function patchLiteral(Request $request, int $id)
    {
        $request->validate([
            'average' => 'required|string:A,B,C,D,E,F'
        ]);

        $average = $request->input('average');

        /**
         * @var Ticket
         */
        $ticket = Ticket::find($id);

        $ticket->average = $average;

        $ticket->save();
    }


    public function patchContent(Request $request, int $id)
    {
        $request->validate([
            'content' => 'required|string|max:2400'
        ]);

        $content = $request->input('content');

        /**
         * @var Ticket
         */
        $ticket = Ticket::find($id);

        $ticket->content = $content;

        $ticket->save();
    }

    public function recreateContent(int $id)
    {
        return $this->ticket->recreateContent($id);
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
