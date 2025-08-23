<?php

namespace App\Factories;

use App\DTOs\Summary\EnrollmentDTO;
use App\DTOs\Summary\StudentDTO;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\DTOs\Summary\DTOSummary;
use App\DTOs\Details\DTODetail;
use App\DTOs\Details\EnrollmentDetailDTO;

class EnrollmentFactory implements Factory
{

    public static function fromRequest(Request $request): EnrollmentDTO
    {
        $validator = Validator::make($request->all(), [
            'grade' => 'required|integer|min:0 |max:6',
            'secction' => 'required|string|max:1',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->messages());
        }

        return new EnrollmentDTO(
            id: 0,
            school_year: '',
            school_moment: 0,
            degree: $request->input('grade'),
            section: $request->input('secction'),
            classroom: 0,
        );
    }

    public static function fromRequestDetail(Request $request): EnrollmentDetailDTO
    {
        return new EnrollmentDetailDTO(
            id: 0,
            school_year: $request->input('school_year'),
            school_moment: $request->input('school_moment'),
            degree: $request->input('grade'),
            section: $request->input('secction'),
            classroom: 0,
        );
    }

    public static function fromArray(array $data): EnrollmentDTO
    {
        return new EnrollmentDTO(
            id: $data['id'] ?? 0,
            school_year: $data['school_year'] ?? '',
            school_moment: $data['school_moment'] ?? 0,
            degree: $data['degree'] ?? 0,
            section: $data['section'] ?? '',
            classroom: $data['classroom'] ?? 0,
        );
    }

    public static function fromArrayDetail(array $data): EnrollmentDetailDTO
    {
        return new EnrollmentDetailDTO(
            id: $data['id'] ?? 0,
            school_year: $data['school_year'] ?? '',
            school_moment: $data['school_moment'] ?? 0,
            degree: $data['degree'] ?? 0,
            section: $data['section'] ?? '',
            classroom: $data['classroom'] ?? 0,
        );
    }
}
