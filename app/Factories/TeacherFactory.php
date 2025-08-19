<?php

namespace App\Factories;

use App\DTOs\Summary\DTOSummary;
use App\DTOs\Summary\TeacherDTO;
use App\DTOs\Summary\UserDTO;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Constants\RoleConstants;

class TeacherFactory implements Factory
{


    public static function fromRequest(Request $request): DTOSummary
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'surname' => 'required|string|max:100',
            'phone' => 'required|integer',
            'email' => 'required|string|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->messages());
        }

        $teacher = new TeacherDTO(
            id: 0,
            name: $request->input('name'),
            surname: $request->input('surname'),
            phone: $request->input('phone')
        );

        $user = new UserDTO(
            id: 0,
            name: $request->input('name'),
            email: $request->input('email'),
            password: $request->input('password')
        );

        $teacher->UserDTO = $user;

        return $teacher;
    }
}
