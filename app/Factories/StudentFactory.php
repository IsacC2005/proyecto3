<?php

namespace App\Factories;

use App\DTOs\Summary\StudentDTO;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\DTOs\Summary\DTOSummary;
use App\DTOs\Details\DTODetail;

class StudentFactory implements Factory
{

    public static function fromRequest(Request $request): StudentDTO
    {
        $validator = Validator::make($request->all(), [
            'degree' => 'required|integer|min:0 |max:6',
            'name' => 'required|string|max:100',
            'surname' => 'required|string|max:100',
            'representative_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->messages());
        }

        // Si la validación pasa, crea y retorna el DTO.
        return new StudentDTO(
            id: 0,
            degree: $request->input('degree'),
            name: $request->input('name'),
            surname: $request->input('surname'),
            representative_id: $request->input('representative_id')
        );
    }

    public static function fromRequestDetail(Request $request): DTODetail
    {
        // Asumiendo que DTODetail espera los mismos campos que StudentDTO, ajusta según tu implementación real
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'degree' => 'required|integer|min:0|max:6',
            'name' => 'required|string|max:100',
            'surname' => 'required|string|max:100',
            'representative_id' => 'integer|nullable',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->messages());
        }

        return new DTODetail(
            id: $request->input('id'),
            degree: $request->input('degree'),
            name: $request->input('name'),
            surname: $request->input('surname'),
            representative: null
        );
    }

    public static function fromArray(array $data): DTOSummary
    {
        // Asumiendo que DTOSummary espera los mismos campos que StudentDTO, ajusta según tu implementación real
        return new DTOSummary(
            id: $data['id'] ?? 0,
            degree: $data['degree'] ?? null,
            name: $data['name'] ?? '',
            surname: $data['surname'] ?? '',
            representative_id: $data['representative_id'] ?? null
        );
    }

    public static function fromArrayDetail(array $data): DTODetail
    {
        // Asumiendo que DTODetail espera los mismos campos que StudentDTO, ajusta según tu implementación real
        return new DTODetail(
            id: $data['id'] ?? 0,
            degree: $data['degree'] ?? null,
            name: $data['name'] ?? '',
            surname: $data['surname'] ?? '',
            representative: null
        );
    }
}
