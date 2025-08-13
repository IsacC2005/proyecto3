<?php

namespace App\Factories;

use App\DTOs\Summary\StudentDTO;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentFactory implements Factory{
    public static function fromRequest(Request $request): StudentDTO{
        $validator = Validator::make($request->all(),[
            'degree' => 'required|integer|length:1',
            'name' => 'required|string|max:100',
            'surname' => 'required|string|max:100',
            'representative_id' => 'integer',
        ]);

        if ($validator->fails()) {
            throw new ValidationException();
        }

        // Si la validación pasa, crea y retorna el DTO.
        return new StudentDTO(
            id: $request->input('id'),
            degree: $request->input('degree'),
            name: $request->input('name'),
            surname: $request->input('surname'),
            representative_id: $request->input('representative_id')
        );
    }
}