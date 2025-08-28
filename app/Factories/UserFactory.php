<?php

namespace App\Factories;

use App\DTOs\Summary\DTOSummary;
use App\DTOs\Summary\UserDTO;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\DTOs\Details\DTODetail;

class UserFactory implements Factory
{


    public static function fromRequest(Request $request): UserDTO
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|unique:users',
            'password' => 'required|string|min:8',
            'roleId' => 'required|exists:roles,id'
        ]);

        if ($validate->fails()) {
            throw new ValidationException();
        }

        return new UserDTO(
            id: $request->id,
            name: $request->name,
            email: $request->email,
            password: $request->password,
            roleId: $request->roleId
        );
    }

    public static function fromRequestDetail(Request $request): DTODetail
    {
        // TODO
    }

    public static function fromArray(array $data): DTOSummary
    {
        // TODO
    }

    public static function fromArrayDetail(array $data): DTODetail
    {
        // TODO
    }
}
