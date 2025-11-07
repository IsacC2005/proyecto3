<?php

namespace App\Http\Controllers;

use App\Constants\TDTO;
use App\DTOs\Summary\UserDTO;
use App\Factories\UserFactory;
use App\Http\Requests\AdminResetPasswordUser;
use App\Http\Requests\AdminUpdateUser;
use App\Services\UserServices;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Role;


class UserController extends Controller
{
    public function __construct(
        private UserServices $userService
    ) {}
    /**
     * Display a listing of the resource.
     * 
     * This method should retrieve all resources from the database
     * and return a view displaying the list of resources.
     */
    public function index()
    {
        return Inertia::render('Users/ListUsers', [
            'users' => $this->userService->findAllUser(),
            'roles' => Role::pluck('name', 'id')->all()
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
        $roles = Role::all();
        return Inertia::render('Users/CreateUser', [
            'roles' => $roles->map(function ($role) {
                return [
                    'id' => $role->id,
                    'name' => $role->name
                ];
            })
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
        $userDTO = UserFactory::fromRequest($request);
        return $this->userService->createUser($userDTO);
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
    public function AdminEditUser(string $id)
    {
        $data = $this->userService->findByUserById($id, TDTO::DETAIL);

        $roles = Role::all()->map(function ($role) {
            return [
                'id' => $role->id,
                'name' => $role->name
            ];
        })->toArray();

        $logs = Activity::with('causer')->where('causer_id', $id)
            ->latest()
            ->paginate(10)
            ->through(function ($activity) {
                return [
                    'id' => $activity->id,
                    'description' => $activity->description,
                    'subject_type' => $activity->subject_type,
                    'subject_id' => $activity->subject_id,
                    'causer_name' => $activity->causer ? $activity->causer->name : 'Sistema',
                    'created_at' => $activity->created_at->diffForHumans(),
                    'properties' => $activity->properties,
                ];
            });

        return Inertia::render('Users/UserEdit/UserEdit', [
            'initialUser' => $data,
            'roles' => $roles,
            'logs' => $logs
        ]);
    }

    /**
     * Update the specified resource in storage.
     * 
     * This method should validate the request data and update
     * the specified resource in the database.
     */

    public function AdminUpdateUser(AdminUpdateUser $request, string $id)
    {

        $data = $request->validated();

        $userDTO = UserFactory::fromArrayDetail($data);
        $userDTO->id = $id;



        $this->userService->AdminUpdateUser($userDTO);
    }


    public function AdminResetPaswordUser(Request $request, string $id)
    {
        $request->validate([
            'password' => 'required|string|min:8|max:254'
        ]);
        $this->userService->AdminResetPaswordUser($request->input('password'), $id);
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
