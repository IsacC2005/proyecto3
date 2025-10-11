<?php

namespace App\Factories;

use App\DTOs\Summary\StudentDTO;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\DTOs\Details\StudentDetailDTO;

class StudentFactory implements Factory
{

    public static function fromRequest(Request $request): StudentDTO
    {
        $validator = Validator::make($request->all(), [
            'grade' => 'required|integer|min:0|max:6',
            'name' => 'required|string|max:100',
            'surname' => 'required|string|max:100',
            'representativeId' => 'required|integer',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->messages());
        }

        // Si la validación pasa, crea y retorna el DTO.
        return new StudentDTO(
            id: 0,
            grade: $request->input('grade'),
            name: $request->input('name'),
            surname: $request->input('surname'),
        );
    }

    public static function fromRequestDetail(Request $request): StudentDetailDTO
    {
        // Asumiendo que DTODetail espera los mismos campos que StudentDTO, ajusta según tu implementación real
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'grade' => 'required|integer|min:0|max:6',
            'name' => 'required|string|max:100',
            'surname' => 'required|string|max:100',
            'representative_id' => 'integer|nullable',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->messages());
        }

        return new StudentDetailDTO(
            id: $request->input('id'),
            grade: $request->input('grade'),
            name: $request->input('name'),
            surname: $request->input('surname'),
        );
    }

    public static function fromArray(array $data): StudentDTO
    {
        // Asumiendo que DTOSummary espera los mismos campos que StudentDTO, ajusta según tu implementación real
        return new StudentDTO(
            id: $data['id'] ?? 0,
            grade: $data['grade'] ?? null,
            name: $data['name'] ?? '',
            surname: $data['surname'] ?? '',
        );
    }

    public static function fromArrayDetail(array $data): StudentDetailDTO
    {
        // Asumiendo que DTODetail espera los mismos campos que StudentDTO, ajusta según tu implementación real
        return new StudentDetailDTO(
            id: $data['id'] ?? 0,
            grade: $data['grade'] ?? null,
            name: $data['name'] ?? '',
            surname: $data['surname'] ?? '',
        );
    }
}
