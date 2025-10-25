<?php

namespace App\Services;

use App\Exceptions\ia\DailyLimitExceededException;
use App\Models\SettingIA;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;

class GeminiServices
{


    public function conection(string $prompContent): string
    {
        $settings = SettingIA::first();

        if (!$settings) {
            throw new \RuntimeException("Configuración de IA no encontrada.");
        }



        $limitKey = config('ia_limits.rate_limit_key');
        $maxAttempts = config('ia_limits.rate_limit');

        // if (RateLimiter::tooManyAttempts($limitKey, $maxAttempts)) {
        //     $seconds = RateLimiter::availableIn($limitKey);
        //     $message = "Límite de peticiones por minuto excedido. Reintente en {$seconds} segundos.";
        //     throw new \RuntimeException($message, 429);
        // }

        // $dailyLimit = config('ia_limits.daily_limit');


        // DB::transaction(function () use ($dailyLimit) {
        //     // Bloqueamos el único registro de uso diario.
        //     $usage = DB::table('ia_daily_usages')->lockForUpdate()->find(1);

        //     // Si es un nuevo día, reseteamos el contador
        //     if ($usage->last_reset_date !== now()->toDateString()) {
        //         DB::table('ia_daily_usages')->where('id', 1)->update([
        //             'request_count' => 0,
        //             'last_reset_date' => now()->toDateString(),
        //             'updated_at' => now(),
        //         ]);
        //         $usage->request_count = 0;
        //     }

        //     // Verificamos el límite diario. Si se excede, lanzamos la excepción
        //     if ($usage->request_count >= $dailyLimit) {
        //         throw new DailyLimitExceededException();
        //     }

        // Si el límite NO se ha alcanzado, incrementamos el contador de forma segura
        //     DB::table('ia_daily_usages')->where('id', 1)->increment('request_count');
        // });

        // RateLimiter::hit($limitKey);


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
