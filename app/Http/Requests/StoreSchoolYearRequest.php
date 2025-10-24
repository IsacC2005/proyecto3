<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSchoolYearRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'school_year' => [
                'required',
                'string',
                // Asegura el formato básico 'YYYY-YYYY' antes de la lógica compleja
                'regex:/^\d{4}-\d{4}$/',

                // 2. REGLA CLOSURE para la LÓGICA: Año 2 = Año 1 + 1
                Rule::closure(function (string $attribute, mixed $value, \Closure $fail) {

                    // 1. Dividir la cadena '2020-2021' en un array ['2020', '2021']
                    $years = explode('-', $value);

                    if (count($years) !== 2) {
                        return $fail("El formato del :attribute es incorrecto. Debe ser YYYY-YYYY.");
                    }

                    // 2. Convertir las partes a enteros para la comparación matemática
                    $year1 = (int) $years[0];
                    $year2 = (int) $years[1];

                    // 3. Verificación de seguridad: Aunque regex lo cubre, comprobamos que sean numéricos.
                    if (!is_numeric($years[0]) || !is_numeric($years[1])) {
                        return $fail("Ambos años deben ser valores numéricos válidos.");
                    }

                    // 4. LÓGICA CLAVE: Verificar que el segundo año sea exactamente 1 más que el primero.
                    if ($year2 !== ($year1 + 1)) {
                        $fail("El segundo año ({$year2}) debe ser exactamente el año siguiente al primero ({$year1}).");
                    }
                }),
            ],
            // ... otras reglas de validación
        ];
    }
}
