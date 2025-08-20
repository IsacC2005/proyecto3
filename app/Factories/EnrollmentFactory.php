<?php

namespace App\Factories;

use App\DTOs\Summary\EnrollmentDTO;
use App\DTOs\Summary\StudentDTO;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EnrollmentFactory implements Factory{

    public static function fromRequest(Request $request): EnrollmentDTO{
        $validator = Validator::make($request->all(),[
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
}
