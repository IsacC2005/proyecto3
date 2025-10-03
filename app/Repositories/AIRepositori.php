<?php

namespace App\Repositories;

use App\Models\LearningProject;
use App\Models\Student;
use App\Repositories\Interfaces\AI;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class AIRepositori
{
    public static function test(): string
    {
        $student = Student::find(1);
        $project = LearningProject::find(1);
        $promp = "Has me una boleta de resumen de notas para el estudiante $student->name, la redaccion no debe repetir de forma execiva el mismo verbo por ejemplo el estudiante domina las operaciones basicas suma resta multiplicacion, el estudiante domina na x cosa, asi no no puedes repetir el mismo verbo, la redaccion debe ser fluida y no debes de decir absolutamente nada negativo del estudiante, esta boleta la debas redactar basandote en las siguientes indicadores evaluados y notas optenidas: ";

        $student_id = $student->id;

        $classes = $project->daily_classes;

        foreach ($classes as $class) {

            $promp .= "En la clase '{$class->title}' obtuvo los siguientes resultados (";

            $evaluation_items = $class->evaluation_items()
                ->whereHas('students', function ($query) use ($student_id) {
                    $query->where('students.id', $student_id);
                })
                ->with(['students' => function ($query) use ($student_id) {
                    $query->where('students.id', $student_id)->withPivot('note');
                }])
                ->get();

            // 2. Construir el string final
            $notes = [];

            foreach ($evaluation_items as $item) {
                // Si la relación con el estudiante existe, obtén la nota del pivot.
                // Esto es seguro porque ya filtramos la consulta.
                if ($item->students->first()) {
                    $note = $item->students->first()->pivot->note;
                    $notes[] = "{$item->title}: {$note}";
                }
            }

            // Unir todas las notas en una sola cadena
            $promp .= implode(', ', $notes);
            $promp .= ");";
        }

        $promp .= ". 
        Muy importante en la calificacion de los estudiantes se usa la siguiente nomenclatura PL plenamente logrado, L logrado, PM por mejorar, EP en proceso, NL no logrado. debes de generar texto plano no le agreges ningun tipado ademas no comiences el texto dando preambulos ni diciendo cosas como resumen de notas, tansolo empiesa de forma fluida y sin preambulos, ademas tampocos nombres una clase en especifico en cambio has todo de forma fluida no digas en la clase tal eso x cosa, en cambio di el estudiante se destaco en x o y actividad ";
        // Reemplaza 'TU_API_KEY_DE_GEMINI' con tu clave API real.
        $apiKey = 'AIzaSyCYHIXWhDs1V6EN9UCZ_knIHK4Uh-q2dmM';
        $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}";

        $client = new Client();

        $payload = [
            'contents' => [
                [
                    'parts' => [
                        [
                            'text' => $promp
                        ]
                    ]

                ]
            ]
        ];

        try {
            $response = $client->post($apiUrl, [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => $payload,
            ]);

            $body = json_decode($response->getBody()->getContents(), true);

            // Verifica si la respuesta tiene el formato esperado
            if (isset($body['candidates'][0]['content']['parts'][0]['text'])) {
                return $body['candidates'][0]['content']['parts'][0]['text'];
            } else {
                return "Error: No se encontró texto en la respuesta de la IA.";
            }
        } catch (RequestException $e) {
            // Maneja los errores de la petición (por ejemplo, clave API incorrecta o problemas de red)
            return "Error de conexión con la API: " . $e->getMessage();
        }
    }
}
