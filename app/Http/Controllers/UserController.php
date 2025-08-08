<?php

namespace App\Http\Controllers;

use App\DTOs\Summary\UserDTO;
use App\services\UserServices;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function __construct(
        private UserServices $userService
    )
    {}
    public function show(){
        $roles = $this->userService->allRoles();
        return Inertia::render('Users/Create', ['roles' => $roles]);
    }

    public function create(Request $request){

        //return $request;
            $validate = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|unique:users',
                'password' => 'required|string|min:8',
                'rol_id' => 'required|exists:roles,id'
            ]);


            $user = $this->userService->createUser(new UserDTO(
                id: 0,
                name: $validate['name'],
                email: $validate['email'],
                password: $validate['password'],
                rol_id: $validate['rol_id']
            ));



            return redirect()->route('dashboard')->with('successe', 'Usuario Creado Correctamente XD');
    }
}
