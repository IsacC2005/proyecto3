<?php

namespace App\Services;

use App\Models\SettingIA;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class GeminiServices
{


    public function conection(string $prompContent): string
    {
        $settings = SettingIA::first();

        $system_instruction = $settings->system_instruction;
        $apiModel = $settings->model;
        $apiKey = $settings->key;

        $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/$apiModel:generateContent?key={$apiKey}";

        $client = new Client();

        $payload = [
            "system_instruction" => [
                "parts" => [
                    [
                        "text" => $system_instruction
                    ]
                ]
            ],

            'contents' => [
                [
                    'parts' => [
                        [
                            'text' =>  $prompContent
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
