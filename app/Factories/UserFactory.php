<?php

namespace App\Factories;

use App\DTOs\Summary\DTOSummary;
use App\DTOs\Summary\UserDTO;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserFactory implements Factory{


	public static function fromRequest(Request $request): UserDTO 
    {
        $validate = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|unique:users',
            'password' => 'required|string|min:8',
            'rol_id' => 'required|exists:roles,id'
        ]);

        if($validate->fails()){
            throw new ValidationException();
        }

        return new UserDTO(
            id: $request->id,
            name: $request->name,
            email: $request->email,
            password: $request->password,
            rol_id: $request->rol_id
        );
    }
}